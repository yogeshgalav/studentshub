<template>
  <div class="autocomplete">
    <input
      :value="search[value]"
      type="text"
      class="form-control"
      @input="showResult($event)"
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
              class="autocomplete-result"
              @click="getEmit({'id':0,'name':search[value]})"
          >
              Create        </li>
        <!--              <li-->
        <!--                  v-if="isLoading"-->
        <!--                  class="loading"-->
        <!--              >-->
        <!--                  {{ $t('vue-auto-complete.loading') }}-->
        <!--              </li>-->
        <li
          v-for="(result, i) in results"
          :key="i"
          class="autocomplete-result"
          :class="{ 'is-active': i === arrowCounter }"
          @click="getEmit(result)"
        >
          <slot
            name="list"
            v-bind="result"
          >
            {{ result[value] }}
          </slot>
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

	props: ['items','value','isAsync',],

	data() {
		return {
			isOpen:false,
			results: [],
            search:{},
            arrowCounter: 0,
		};
	},
	watch : {
         items: function (val) {
             this.results= val;

         }
  },
	methods: {
	    getEmit: function (currentResult) {
			this.$emit('selected', currentResult );
			this.search = currentResult;
			this.isOpen=false;
		},
		showResult(event){
      this.search[this.value]= event.target.value;
			if(this.isAsync){
				this.$emit('setValue', this.search[this.value]);
			}else {
				this.filterResults();
			}
      this.isOpen = true;
		},
		filterResults() {
      this.results = this.items.filter((item) => {
				if (item[this.value].toLowerCase().indexOf(this.search[this.value].toLowerCase())>-1) {
					return true;
        }
        return false;
      });
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


	}

};
</script>
