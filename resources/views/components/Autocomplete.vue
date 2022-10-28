<template>
    <div class="autocomplete relavtive form-group">
      <input
        type="text"
        class="form-control"
        @input="onChange"
        v-model="search"
        @keydown.down="onArrowDown"
        @keydown.up="onArrowUp"
        @keydown.enter="onEnter"
      />
      <ul
        v-show="isOpen"
        class="autocomplete-results mt-0.5 border-2 border-slate-50 overflow-auto	shadow-lg rounded"
      >
        <li
          class="loading"
          v-if="isLoading"
        >
          Loading results...
        </li>
        <li
          v-else
          v-for="(result, i) in results"
          :key="i"
          @click="setResult(result)"
          class="autocomplete-result w-full	list-none	text-left	p-2.5 cursor-pointer	hover:bg-slate-50"
          :class="{ 'is-active': i === arrowCounter }"
        >
          {{ result[label] }}
        </li>
      </ul>
    </div>
  </template>
  
  <script>
    export default {
      name: 'Autocomplete',
      props: {
        items: {
          type: Array,
          required: false,
          default: () => [],
        },
        label: {
          type: String,
          required: false,
          default: 'name',
        },
        isAsync: {
          type: Boolean,
          required: false,
          default: false,
        },
      },
      data() {
        return {
          isOpen: false,
          results: [],
          search: '',
          isLoading: false,
          arrowCounter: -1,
        };
      },
      watch: {
        items: function (value, oldValue) {
          if (value.length !== oldValue.length) {
            this.results = value;
            this.isLoading = false;
          }
        },
      },
      mounted() {
        document.addEventListener('click', this.handleClickOutside)
      },
      destroyed() {
        document.removeEventListener('click', this.handleClickOutside)
      },
      methods: {
        setResult(result) {
          this.search = result[this.label];
          this.isOpen = false;
          this.$emit('setResult',result);
        },
        filterResults() {
          this.results = this.items.filter((item) => {
            return item[this.label].toLowerCase().indexOf(this.search.toLowerCase()) > -1;
          });
        },
        onChange() {
          if (this.isAsync) {
            this.isLoading = true;
          } else {
            this.filterResults();
            this.isOpen = true;
          }
        },
        handleClickOutside(event) {
          if (!this.$el.contains(event.target)) {
            this.isOpen = false;
            this.arrowCounter = -1;
          }
        },
        onArrowDown() {
          if (this.arrowCounter < this.results.length) {
            this.arrowCounter = this.arrowCounter + 1;
          }
        },
        onArrowUp() {
          if (this.arrowCounter > 0) {
            this.arrowCounter = this.arrowCounter - 1;
          }
        },
        onEnter() {
          this.setResult(this.results[this.arrowCounter]);
          this.arrowCounter = -1;
        },
      },
    };
  </script>
  
  <style>
    .autocomplete-result.is-active{
      background-color: #e0f2fe;
    color: #2563eb;
    }
  </style>