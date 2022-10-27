<template>
    <div class="autocomplete form-group">
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
        class="autocomplete-results"
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
          class="autocomplete-result"
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
    .autocomplete {
      position: relative;
    }
  
    .autocomplete-results {
      padding: 0;
      margin: 0;
      border: 2px solid #eeeeee;
      border-top: 0;
      /* max-height: 120px; */
      overflow: auto;
    }
  
    .autocomplete-result {
      width: 100%;
      list-style: none;
      text-align: left;
      padding: 6px 8px;
      cursor: pointer;
      /* border-bottom: 2px solid #eeeeee; */
    }
  
    .autocomplete-result.is-active,
    .autocomplete-result:hover {
      background-color: rgb(229 231 235);
    }

    
  </style>