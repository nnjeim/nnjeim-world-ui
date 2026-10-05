import './catalog';

const snippets = {
    blade: {
        filename: 'country-select.blade.php',
        code: `@php
    use Nnjeim\\World\\World;

    $countries = World::countries([
        'fields' => 'iso2',
    ])->data;
@endphp

<label for="country">Country</label>
<select id="country" name="country_id">
    <option value="">Choose a country</option>
    @foreach ($countries as $country)
        <option value="{{ $country->id }}">
            {{ $country->name }} ({{ $country->iso2 }})
        </option>
    @endforeach
</select>`,
    },
    react: {
        filename: 'CountrySelect.jsx',
        code: `import { useEffect, useState } from 'react';

export function CountrySelect() {
  const [countries, setCountries] = useState([]);
  const [countryId, setCountryId] = useState('');

  useEffect(() => {
    fetch('/api/countries?fields=iso2')
      .then((response) => response.json())
      .then(({ data }) => setCountries(data));
  }, []);

  return (
    <select
      value={countryId}
      onChange={(event) => setCountryId(event.target.value)}
    >
      <option value="">Choose a country</option>
      {countries.map((country) => (
        <option key={country.id} value={country.id}>
          {country.name} ({country.iso2})
        </option>
      ))}
    </select>
  );
}`,
    },
    angular: {
        filename: 'country-select.component.ts',
        code: `import { Component, inject } from '@angular/core';
import { HttpClient } from '@angular/common/http';

interface Country {
  id: number;
  iso2: string;
  name: string;
}

interface ApiResponse {
  data: Country[];
}

@Component({
  selector: 'app-country-select',
  template: \`
    <select name="countryId">
      <option value="">Choose a country</option>
      @for (country of countries; track country.id) {
        <option [value]="country.id">
          {{ country.name }} ({{ country.iso2 }})
        </option>
      }
    </select>
  \`,
})
export class CountrySelectComponent {
  private http = inject(HttpClient);
  countries: Country[] = [];

  ngOnInit() {
    this.http.get<ApiResponse>('/api/countries?fields=iso2')
      .subscribe(({ data }) => this.countries = data);
  }
}`,
    },
    vue: {
        filename: 'CountrySelect.vue',
        code: `<script setup>
import { onMounted, ref } from 'vue';

const countries = ref([]);
const countryId = ref('');

onMounted(async () => {
  const response = await fetch('/api/countries?fields=iso2');
  const { data } = await response.json();
  countries.value = data;
});
</script>

<template>
  <select v-model="countryId">
    <option value="">Choose a country</option>
    <option
      v-for="country in countries"
      :key="country.id"
      :value="country.id"
    >
      {{ country.name }} ({{ country.iso2 }})
    </option>
  </select>
</template>`,
    },
};

const setCopyFeedback = (button, message) => {
    const label = button.querySelector('[data-copy-label]');
    const original = label?.textContent;

    if (!label) {
        return;
    }

    label.textContent = message;
    window.setTimeout(() => {
        label.textContent = original;
    }, 1600);
};

const copyText = async (text) => {
    if (navigator.clipboard && window.isSecureContext) {
        await navigator.clipboard.writeText(text);

        return;
    }

    const textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.style.position = 'fixed';
    textarea.style.opacity = '0';
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand('copy');
    textarea.remove();
};

document.querySelectorAll('[data-copy-text]').forEach((button) => {
    button.addEventListener('click', async () => {
        try {
            await copyText(button.dataset.copyText);
            setCopyFeedback(button, 'Copied');
        } catch {
            setCopyFeedback(button, 'Try again');
        }
    });
});

const codeBlock = document.querySelector('[data-code-block]');
const codeFilename = document.querySelector('[data-code-filename]');
const copyCodeButton = document.querySelector('[data-copy-code]');
let activeFramework = 'blade';

const showSnippet = (framework) => {
    const snippet = snippets[framework];

    if (!snippet || !codeBlock || !codeFilename) {
        return;
    }

    activeFramework = framework;
    codeBlock.textContent = snippet.code;
    codeFilename.textContent = snippet.filename;

    document.querySelectorAll('[data-framework-tab]').forEach((tab) => {
        const isActive = tab.dataset.frameworkTab === framework;
        tab.classList.toggle('is-active', isActive);
        tab.setAttribute('aria-selected', String(isActive));
    });
};

document.querySelectorAll('[data-framework-tab]').forEach((tab) => {
    tab.addEventListener('click', () => showSnippet(tab.dataset.frameworkTab));
});

copyCodeButton?.addEventListener('click', async () => {
    try {
        await copyText(snippets[activeFramework].code);
        setCopyFeedback(copyCodeButton, 'Copied');
    } catch {
        setCopyFeedback(copyCodeButton, 'Try again');
    }
});

showSnippet(activeFramework);

const selector = document.querySelector('[data-country-selector]');

if (selector) {
    const input = selector.querySelector('[data-country-search]');
    const inputFlag = selector.querySelector('[data-country-input-flag]');
    const toggle = selector.querySelector('[data-country-toggle]');
    const chevron = selector.querySelector('[data-country-chevron]');
    const options = selector.querySelector('[data-country-options]');
    const list = selector.querySelector('[data-country-list]');
    const loading = selector.querySelector('[data-country-loading]');
    const empty = selector.querySelector('[data-country-empty]');
    const status = selector.querySelector('[data-country-status]');
    const selectedFlag = selector.querySelector('[data-selected-flag]');
    const selectedName = selector.querySelector('[data-selected-name]');
    const selectedIso = selector.querySelector('[data-selected-iso]');
    const selectedId = selector.querySelector('[data-selected-id]');

    let countries = [];
    let visibleCountries = [];
    let highlightedIndex = -1;
    let selectedCountry = null;

    const flagFromIso = (iso2) =>
        iso2
            ? [...iso2.toUpperCase()]
                  .map((character) => String.fromCodePoint(127397 + character.charCodeAt()))
                  .join('')
            : '🌍';

    const openOptions = () => {
        options.classList.remove('hidden');
        input.setAttribute('aria-expanded', 'true');
        chevron.classList.add('rotate-180');
    };

    const closeOptions = () => {
        options.classList.add('hidden');
        input.setAttribute('aria-expanded', 'false');
        input.removeAttribute('aria-activedescendant');
        chevron.classList.remove('rotate-180');
        highlightedIndex = -1;
    };

    const selectCountry = (country) => {
        selectedCountry = country;
        input.value = country.name;
        inputFlag.textContent = flagFromIso(country.iso2);
        selectedFlag.textContent = flagFromIso(country.iso2);
        selectedName.textContent = country.name;
        selectedIso.textContent = country.iso2 ?? '—';
        selectedId.textContent = country.id;
        status.textContent = `${country.name} selected`;
        closeOptions();
    };

    const renderOptions = (query = '') => {
        const normalizedQuery = query.trim().toLocaleLowerCase();
        visibleCountries = countries
            .filter(
                (country) =>
                    !normalizedQuery ||
                    country.name.toLocaleLowerCase().includes(normalizedQuery) ||
                    country.iso2?.toLocaleLowerCase().includes(normalizedQuery),
            )
            .slice(0, 12);

        list.replaceChildren();
        empty.classList.toggle('hidden', visibleCountries.length > 0);

        visibleCountries.forEach((country, index) => {
            const option = document.createElement('button');
            const flag = document.createElement('span');
            const name = document.createElement('span');
            const iso = document.createElement('span');

            option.type = 'button';
            option.className = 'country-option';
            option.id = `country-option-${country.id}`;
            option.setAttribute('role', 'option');
            option.setAttribute('aria-selected', String(country.id === selectedCountry?.id));
            option.dataset.countryIndex = String(index);
            option.classList.toggle('is-selected', country.id === selectedCountry?.id);

            flag.className = 'text-lg';
            flag.textContent = flagFromIso(country.iso2);
            name.className = 'min-w-0 flex-1 truncate';
            name.textContent = country.name;
            iso.className = 'font-mono text-xs text-slate-400';
            iso.textContent = country.iso2 ?? '';

            option.append(flag, name, iso);
            option.addEventListener('mousedown', (event) => event.preventDefault());
            option.addEventListener('click', () => selectCountry(country));
            list.appendChild(option);
        });

        status.textContent = visibleCountries.length
            ? `${visibleCountries.length} ${visibleCountries.length === 1 ? 'match' : 'matches'} shown`
            : 'No matching countries';
    };

    const updateHighlight = () => {
        list.querySelectorAll('[data-country-index]').forEach((option, index) => {
            const isHighlighted = index === highlightedIndex;
            option.classList.toggle('is-highlighted', isHighlighted);

            if (isHighlighted) {
                input.setAttribute('aria-activedescendant', option.id);
                option.scrollIntoView({ block: 'nearest' });
            }
        });
    };

    input.addEventListener('focus', () => {
        renderOptions(input.value === selectedCountry?.name ? '' : input.value);
        openOptions();
    });

    input.addEventListener('input', () => {
        inputFlag.textContent = '🔎';
        highlightedIndex = -1;
        renderOptions(input.value);
        openOptions();
    });

    input.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowDown') {
            event.preventDefault();

            if (!visibleCountries.length) {
                return;
            }

            openOptions();
            highlightedIndex = Math.min(highlightedIndex + 1, visibleCountries.length - 1);
            updateHighlight();
        } else if (event.key === 'ArrowUp') {
            event.preventDefault();

            if (!visibleCountries.length) {
                return;
            }

            highlightedIndex = Math.max(highlightedIndex - 1, 0);
            updateHighlight();
        } else if (event.key === 'Enter' && highlightedIndex >= 0) {
            event.preventDefault();
            selectCountry(visibleCountries[highlightedIndex]);
        } else if (event.key === 'Escape') {
            closeOptions();
        }
    });

    input.addEventListener('blur', () => {
        window.setTimeout(() => {
            closeOptions();

            if (selectedCountry && input.value.trim() !== selectedCountry.name) {
                selectCountry(selectedCountry);
            }
        }, 100);
    });

    toggle.addEventListener('click', () => {
        if (options.classList.contains('hidden')) {
            input.focus();
        } else {
            closeOptions();
        }
    });

    fetch('/api/countries?fields=iso2')
        .then((response) => {
            if (!response.ok) {
                throw new Error('Country API request failed');
            }

            return response.json();
        })
        .then(({ data }) => {
            countries = Array.isArray(data) ? data : [];
            loading.classList.add('hidden');
            selectedCountry = countries.find((country) => country.iso2 === 'RO') ?? countries[0] ?? null;

            if (selectedCountry) {
                selectCountry(selectedCountry);
            }

            renderOptions();
            status.textContent = `${countries.length} countries loaded`;
        })
        .catch(() => {
            loading.textContent = 'Countries could not be loaded. Try again shortly.';
            status.textContent = 'The live API is temporarily unavailable';
        });
}

const apiUsage = document.querySelector('[data-api-usage]');

if (apiUsage) {
    const requests = apiUsage.querySelector('[data-api-usage-requests]');
    const success = apiUsage.querySelector('[data-api-usage-success]');
    const latency = apiUsage.querySelector('[data-api-usage-latency]');
    const chart = apiUsage.querySelector('[data-api-usage-chart]');
    const status = apiUsage.querySelector('[data-api-usage-status]');

    fetch(apiUsage.dataset.url)
        .then((response) => {
            if (!response.ok) {
                throw new Error('API activity request failed');
            }

            return response.json();
        })
        .then((data) => {
            requests.textContent = new Intl.NumberFormat('en').format(data.requests);
            success.textContent = data.success_rate_percent === null ? '—' : `${data.success_rate_percent}%`;
            latency.textContent = data.p95_latency_overflow
                ? '>6.4 s'
                : data.p95_latency_ms === null
                  ? '—'
                  : `≤${new Intl.NumberFormat('en').format(data.p95_latency_ms)} ms`;

            const highest = Math.max(...data.daily.map((day) => day.requests), 1);
            const bars = data.daily.map((day) => {
                const bar = document.createElement('span');
                bar.className = day.requests
                    ? 'min-w-0 flex-1 rounded-t-sm bg-[#f45143]/75'
                    : 'min-w-0 flex-1 rounded-t-sm bg-slate-200';
                bar.style.height = day.requests ? `${Math.max(6, (day.requests / highest) * 100)}%` : '2px';
                bar.title = `${day.date}: ${day.requests} requests`;

                return bar;
            });

            chart.replaceChildren(...bars);
            status.textContent = data.requests === 0
                ? 'Collecting activity from this hosted API.'
                : `Updated ${new Date(data.updated_at).toLocaleString('en', { timeZone: 'UTC', dateStyle: 'medium', timeStyle: 'short' })} UTC`;
        })
        .catch(() => {
            status.textContent = 'API activity is temporarily unavailable.';
        });
}
