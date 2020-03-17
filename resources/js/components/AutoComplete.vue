<template>
  <div class="autocomplete">
    <input
      v-model="search"
      type="text"
      class="form-control"
      @input="onChange"
      @keydown.down="onArrowDown"
      @keydown.up="onArrowUp"
      @keydown.enter="onEnter"
    >
    <transition name="fade">
      <ul
        v-show="isOpen"
        id="autocomplete-results"
        class="autocomplete-results"
      >
        <li
          v-if="isLoading"
          class="loading"
        >
          {{ trans('loading...') }}
        </li>
        <li
          v-for="(currentResult, i) in results"
          v-else
          :key="i"
          class="autocomplete-result"
          :class="{ 'is-active': i === arrowCounter }"
          @click="setResult(currentResult)"
        >
          <slot
            name="list"
            v-bind="currentResult"
          >
            {{ currentResult[value] }}
          </slot>
        </li>
		<li
		v-if="results.length===0"
		class="autocomplete-result"
		@click="$emit('selected', {'id':0,'name':search})"
        >
          {{ trans('Create New') }}
        </li>
      </ul>
    </transition>
  </div>
</template>

<style>
  .autocomplete {
    position: relative;
  }

  .autocomplete-results {
    padding: 0;
    margin: 0;
    border: 1px solid #eeeeee;
    overflow: auto;
    width: 100%;
  }

  .autocomplete-result {
    list-style: none;
    text-align: left;
    padding: 4px 2px;
    cursor: pointer;
  }

  .autocomplete-result.is-active,
  .autocomplete-result:hover {
    background-color: #4AAE9B;
    color: white;
  }

</style>
<script>
export default {
	name: 'Autocomplete',

	props: {
		value: {
			type: String,
			required: true,
			default: () => 'name',
		},
		items: {
			type: Array,
			required: true,
			default: () => [],
		},
		isAsync: {
			type: Boolean,
			required: false,
			default: false,
		},
		isLoading: {
			type: Boolean,
			required: false,
			default: false,
		},
	},

	data() {
		return {
			isOpen: false,
			results: [],
			result:{},
			search: '',
			arrowCounter: 0,
		};
	},
	watch: {
		items: function (val, oldValue) {
			// actually compare them
			if (val.length) {
				this.results = val;
        		this.isOpen = true;
			}
		},
		search: function (val) {
			if (val !== '') {
				this.$emit('selected', {'id':0,'name':val});
			}
		},
	},
	mounted() {
		document.addEventListener('click', this.handleClickOutside);
	},
	destroyed() {
		document.removeEventListener('click', this.handleClickOutside);
	},

	methods: {
    trans: function(string, defaultString) {
      return this.$trans("auth", string, defaultString);
    },
		onChange() {
			// Let's warn the parent that a change was made
			this.$emit('input', this.search);
			// Is the data given by an outside ajax request?
			if (this.isAsync) {
        if(this.items.length){
          return false;
        }
			} else {
				// Let's  our flat array
				this.filterResults();
				this.isOpen = true;
			}
		},

		filterResults() {
			// first uncapitalize all the things
			this.results = this.items.filter((item) => {
				return item.toLowerCase().indexOf(this.search.toLowerCase()) > -1;
			});
		},
		setResult(result) {
			this.search = result[this.value];
			this.isOpen = false;
		},
		onArrowDown() {
			if (this.arrowCounter < this.results.length) {
				this.arrowCounter = this.arrowCounter + 1;
			}
		},
		onArrowUp() {
			if (this.arrowCounter > 0) {
				this.arrowCounter = this.arrowCounter -1;
			}
		},
		onEnter() {
			this.search = this.results[this.arrowCounter];
			this.isOpen = false;
			this.arrowCounter = -1;
		},
		handleClickOutside(evt) {
			if (!this.$el.contains(evt.target)) {
				this.isOpen = false;
				this.arrowCounter = -1;
			}
		}
	}
};
</script>