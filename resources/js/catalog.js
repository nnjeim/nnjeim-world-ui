const catalogPage = document.querySelector('[data-component-page]');

const simpleComponents = {
    'country-selector': {
        singular: 'country',
        plural: 'countries',
        endpoint: '/api/countries?fields=iso2',
        fields: 'iso2',
        defaultMatch: (item) => item.iso2 === 'RO',
        optionLabel: (item) => `${flagFromIso(item.iso2)} ${item.name} · ${item.iso2}`,
        resultLabel: (item) => `${item.name} · ${item.iso2} · ID ${item.id}`,
        bladeLabel: '{{ $country->name }} ({{ $country->iso2 }})',
        jsLabel: '${country.name} (${country.iso2})',
    },
    'currency-selector': {
        singular: 'currency',
        plural: 'currencies',
        endpoint: '/api/currencies?fields=code,symbol',
        fields: 'code,symbol',
        defaultMatch: (item) => item.code === 'EUR',
        optionLabel: (item) => `${item.symbol ?? '¤'} ${item.name} · ${item.code}`,
        resultLabel: (item) => `${item.name} · ${item.code} · ${item.symbol ?? '¤'}`,
        bladeLabel: '{{ $currency->symbol }} {{ $currency->name }} ({{ $currency->code }})',
        jsLabel: '${currency.symbol} ${currency.name} (${currency.code})',
    },
    'language-selector': {
        singular: 'language',
        plural: 'languages',
        endpoint: '/api/languages?fields=name_native,dir',
        fields: 'name_native,dir',
        defaultMatch: (item) => item.code === 'ro',
        optionLabel: (item) => `${item.name} · ${item.name_native}`,
        resultLabel: (item) => `${item.name_native} · ${item.code} · ${item.dir.toUpperCase()}`,
        bladeLabel: '{{ $language->name }} — {{ $language->name_native }}',
        jsLabel: '${language.name} — ${language.name_native}',
    },
    'timezone-selector': {
        singular: 'timezone',
        plural: 'timezones',
        endpoint: '/api/timezones',
        fields: null,
        defaultMatch: (item) => item.name === 'Europe/Bucharest',
        optionLabel: (item) => item.name.replaceAll('_', ' '),
        resultLabel: (item) => `${item.name} · ID ${item.id}`,
        bladeLabel: '{{ $timezone->name }}',
        jsLabel: '${timezone.name}',
    },
};

function flagFromIso(iso2) {
    return iso2
        ? [...iso2.toUpperCase()]
              .map((character) => String.fromCodePoint(127397 + character.charCodeAt()))
              .join('')
        : '🌍';
}

function simpleSnippets(config) {
    const singularTitle = config.singular.charAt(0).toUpperCase() + config.singular.slice(1);
    const fieldsArgument = config.fields ? `['fields' => '${config.fields}']` : '';
    const endpoint = config.endpoint;

    return {
        blade: {
            filename: `${config.singular}-select.blade.php`,
            code: `@php
    use Nnjeim\\World\\World;

    $${config.plural} = World::${config.plural}(${fieldsArgument})->data;
@endphp

<label for="${config.singular}">${singularTitle}</label>
<select id="${config.singular}" name="${config.singular}_id" required>
    <option value="">Choose ${config.singular}</option>
    @foreach ($${config.plural} as $${config.singular})
        <option value="{{ $${config.singular}->id }}">
            ${config.bladeLabel}
        </option>
    @endforeach
</select>`,
        },
        react: {
            filename: `${singularTitle}Select.jsx`,
            code: `import { useEffect, useState } from 'react';

export function ${singularTitle}Select() {
  const [items, setItems] = useState([]);
  const [value, setValue] = useState('');

  useEffect(() => {
    fetch('${endpoint}')
      .then((response) => response.json())
      .then(({ data }) => setItems(data));
  }, []);

  return (
    <select value={value} onChange={(event) => setValue(event.target.value)}>
      <option value="">Choose ${config.singular}</option>
      {items.map((${config.singular}) => (
        <option key={${config.singular}.id} value={${config.singular}.id}>
          {\`${config.jsLabel}\`}
        </option>
      ))}
    </select>
  );
}`,
        },
        angular: {
            filename: `${config.singular}-select.component.ts`,
            code: `import { Component, inject } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-${config.singular}-select',
  template: \`
    <select name="${config.singular}Id">
      <option value="">Choose ${config.singular}</option>
      @for (item of items; track item.id) {
        <option [value]="item.id">{{ item.name }}</option>
      }
    </select>
  \`,
})
export class ${singularTitle}SelectComponent {
  private http = inject(HttpClient);
  items: Array<{ id: number; name: string }> = [];

  ngOnInit() {
    this.http.get<{ data: Array<{ id: number; name: string }> }>('${endpoint}')
      .subscribe(({ data }) => this.items = data);
  }
}`,
        },
        vue: {
            filename: `${singularTitle}Select.vue`,
            code: `<script setup>
import { onMounted, ref } from 'vue';

const items = ref([]);
const value = ref('');

onMounted(async () => {
  const response = await fetch('${endpoint}');
  const { data } = await response.json();
  items.value = data;
});
</script>

<template>
  <select v-model="value">
    <option value="">Choose ${config.singular}</option>
    <option v-for="item in items" :key="item.id" :value="item.id">
      {{ item.name }}
    </option>
  </select>
</template>`,
        },
    };
}

const locationSnippets = {
    blade: {
        filename: 'location-select.blade.php',
        code: `@php
    use Nnjeim\\World\\World;

    $countries = World::countries(['fields' => 'iso2'])->data;
    $states = request('country_code')
        ? World::states(['filters' => ['country_code' => request('country_code')]])->data
        : collect();
    $cities = request('state_id')
        ? World::cities(['filters' => ['state_id' => request('state_id')]])->data
        : collect();
@endphp

<select name="country_code" onchange="this.form.submit()">…</select>
<select name="state_id" onchange="this.form.submit()">…</select>
<select name="city_id">…</select>`,
    },
    react: {
        filename: 'LocationSelect.jsx',
        code: `const loadStates = async (countryCode) => {
  const query = new URLSearchParams({
    'filters[country_code]': countryCode,
    fields: 'country_code',
  });
  const response = await fetch(\`/api/states?\${query}\`);
  const { data } = await response.json();
  setStates(data);
  setCities([]);
};

const loadCities = async (stateId) => {
  const query = new URLSearchParams({ 'filters[state_id]': stateId });
  const response = await fetch(\`/api/cities?\${query}\`);
  const { data } = await response.json();
  setCities(data);
};`,
    },
    angular: {
        filename: 'location-select.component.ts',
        code: `loadStates(countryCode: string) {
  const params = {
    'filters[country_code]': countryCode,
    fields: 'country_code',
  };

  this.http.get<ApiResponse<State>>('/api/states', { params })
    .subscribe(({ data }) => {
      this.states = data;
      this.cities = [];
    });
}

loadCities(stateId: number) {
  const params = { 'filters[state_id]': stateId };
  this.http.get<ApiResponse<City>>('/api/cities', { params })
    .subscribe(({ data }) => this.cities = data);
}`,
    },
    vue: {
        filename: 'LocationSelect.vue',
        code: `<script setup>
import { ref } from 'vue';

const states = ref([]);
const cities = ref([]);

async function loadStates(countryCode) {
  const query = new URLSearchParams({
    'filters[country_code]': countryCode,
    fields: 'country_code',
  });
  states.value = (await (await fetch(\`/api/states?\${query}\`)).json()).data;
  cities.value = [];
}

async function loadCities(stateId) {
  const query = new URLSearchParams({ 'filters[state_id]': stateId });
  cities.value = (await (await fetch(\`/api/cities?\${query}\`)).json()).data;
}
</script>`,
    },
};

async function copyText(text) {
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
}

function setCopyFeedback(button, message) {
    const label = button.querySelector('[data-copy-label]');
    const original = label?.textContent;

    if (!label) {
        return;
    }

    label.textContent = message;
    window.setTimeout(() => {
        label.textContent = original;
    }, 1600);
}

async function fetchData(path) {
    const response = await fetch(path);

    if (!response.ok) {
        throw new Error(`World API returned ${response.status}`);
    }

    const payload = await response.json();

    if (!Array.isArray(payload.data)) {
        throw new Error('World API returned an invalid payload');
    }

    return payload.data;
}

function populateSelect(select, items, label, selectedId = null) {
    select.replaceChildren();

    items.forEach((item) => {
        const option = document.createElement('option');
        option.value = String(item.id);
        option.textContent = label(item);
        option.selected = item.id === selectedId;
        select.appendChild(option);
    });

    select.disabled = items.length === 0;
}

async function initializeSingleSelect(slug, status) {
    const config = simpleComponents[slug];
    const root = catalogPage.querySelector('[data-single-select-demo]');
    const search = root?.querySelector('[data-demo-search]');
    const select = root?.querySelector('[data-demo-select]');
    const result = root?.querySelector('[data-demo-result]');

    if (!config || !root || !search || !select || !result) {
        return;
    }

    const items = await fetchData(config.endpoint);
    let selected = items.find(config.defaultMatch) ?? items[0] ?? null;

    const render = (query = '') => {
        const normalizedQuery = query.trim().toLocaleLowerCase();
        const filteredItems = items.filter((item) => config.optionLabel(item).toLocaleLowerCase().includes(normalizedQuery));
        populateSelect(select, filteredItems, config.optionLabel, selected?.id);
        status.textContent = `${filteredItems.length} ${filteredItems.length === 1 ? 'result' : 'results'} shown`;
    };

    const updateResult = () => {
        selected = items.find((item) => String(item.id) === select.value) ?? null;
        result.textContent = selected ? config.resultLabel(selected) : 'Nothing selected';
    };

    search.addEventListener('input', () => {
        render(search.value);
        updateResult();
    });
    select.addEventListener('change', updateResult);

    render();
    updateResult();
    status.textContent = `${items.length} items loaded from the live API`;
}

async function initializeLocationSelect(status) {
    const root = catalogPage.querySelector('[data-location-demo]');
    const countrySelect = root?.querySelector('[data-location-country]');
    const stateSelect = root?.querySelector('[data-location-state]');
    const citySelect = root?.querySelector('[data-location-city]');
    const result = root?.querySelector('[data-location-result]');

    if (!root || !countrySelect || !stateSelect || !citySelect || !result) {
        return;
    }

    let countries = [];
    let states = [];
    let cities = [];

    const updateResult = () => {
        const country = countries.find((item) => String(item.id) === countrySelect.value);
        const state = states.find((item) => String(item.id) === stateSelect.value);
        const city = cities.find((item) => String(item.id) === citySelect.value);
        result.textContent = [country?.name, state?.name, city?.name].filter(Boolean).join(' · ');
    };

    const loadCities = async (stateId, preferredId = null) => {
        citySelect.disabled = true;
        citySelect.replaceChildren(new Option('Loading cities…'));
        const query = new URLSearchParams({
            'filters[state_id]': stateId,
            fields: 'state_id,country_code',
        });
        cities = await fetchData(`/api/cities?${query}`);
        populateSelect(citySelect, cities, (item) => item.name, preferredId);
        updateResult();
        status.textContent = `${cities.length} cities loaded for the selected state`;
    };

    const loadStates = async (countryCode, preferredId = null, preferredCityId = null) => {
        stateSelect.disabled = true;
        citySelect.disabled = true;
        stateSelect.replaceChildren(new Option('Loading states…'));
        citySelect.replaceChildren(new Option('Choose a state first'));
        const query = new URLSearchParams({
            'filters[country_code]': countryCode,
            fields: 'country_code',
        });
        states = await fetchData(`/api/states?${query}`);
        populateSelect(stateSelect, states, (item) => item.name, preferredId);

        if (stateSelect.value) {
            await loadCities(stateSelect.value, preferredCityId);
        }
    };

    countrySelect.addEventListener('change', async () => {
        const country = countries.find((item) => String(item.id) === countrySelect.value);

        if (country) {
            await loadStates(country.iso2);
        }
    });
    stateSelect.addEventListener('change', () => loadCities(stateSelect.value));
    citySelect.addEventListener('change', updateResult);

    countries = await fetchData('/api/countries?fields=iso2');
    const romania = countries.find((item) => item.iso2 === 'RO') ?? countries[0];
    populateSelect(countrySelect, countries, (item) => `${flagFromIso(item.iso2)} ${item.name}`, romania?.id);

    if (romania) {
        await loadStates(romania.iso2, 3338, 95226);
    }

    status.textContent = 'Country, state, and city are connected to the live API';
}

if (catalogPage) {
    const slug = catalogPage.dataset.componentPage;
    const status = catalogPage.querySelector('[data-demo-status]');
    const codeBlock = catalogPage.querySelector('[data-catalog-code]');
    const filename = catalogPage.querySelector('[data-catalog-filename]');
    const copyButton = catalogPage.querySelector('[data-copy-catalog-code]');
    const snippets = slug === 'location-selector' ? locationSnippets : simpleSnippets(simpleComponents[slug]);
    let framework = 'blade';

    const showSnippet = (selectedFramework) => {
        const snippet = snippets[selectedFramework];

        if (!snippet || !codeBlock || !filename) {
            return;
        }

        framework = selectedFramework;
        codeBlock.textContent = snippet.code;
        filename.textContent = snippet.filename;

        catalogPage.querySelectorAll('[data-catalog-framework]').forEach((tab) => {
            const isActive = tab.dataset.catalogFramework === framework;
            tab.classList.toggle('is-active', isActive);
            tab.setAttribute('aria-selected', String(isActive));
        });
    };

    catalogPage.querySelectorAll('[data-catalog-framework]').forEach((tab) => {
        tab.addEventListener('click', () => showSnippet(tab.dataset.catalogFramework));
    });

    copyButton?.addEventListener('click', async () => {
        try {
            await copyText(snippets[framework].code);
            setCopyFeedback(copyButton, 'Copied');
        } catch {
            setCopyFeedback(copyButton, 'Try again');
        }
    });

    showSnippet(framework);

    const initializeDemo = slug === 'location-selector'
        ? initializeLocationSelect(status)
        : initializeSingleSelect(slug, status);

    initializeDemo.catch(() => {
        status.textContent = 'The live API is temporarily unavailable';
    });
}
