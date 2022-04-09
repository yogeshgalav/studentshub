<template>
  <div class="vue-good-table table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th
            v-for="(column,key) in table_columns"
            :key="key"
            class="text-center"
            @click="sortFunction(column,key)"
          >
            {{ column.labelTop!==undefined? String(column.labelTop) : '' }} <br>
            {{ String(column.label) }}
            <i
              v-if="column.sorting!==false"
              :class="['fa',sortArrow(key)]"
              aria-hidden="true"
            />
          </th>
        </tr>
      </thead>
      <tbody v-if="!table_rows.length">
        <tr>
          <td colspan="9">
            <slot name="emptystate" />
          </td>
        </tr>
      </tbody>
      <transition-group
        v-if="table_rows.length"
        name="fade"
        tag="tbody"
      >
        <tr
          v-for="(row,key) in table_rows"
          :key="key+1"
        >
          <td
            v-for="(column,key2) in table_columns"
            :key="key2"
            class="text-center"
          >
            <slot
              :row="row"
              :column="column"
              name="table-row"
            >
              {{ row[column.field] }}
            </slot>
          </td>
        </tr>
      </transition-group>
      <tfoot v-if="Object.keys(footer_rows).length">
        <tr>
          <td
            v-for="(column,key2) in columns"
            :key="key2"
          >
            {{ footer_rows[column.field] }}
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</template>
<style scoped>
.vue-good-table .table td,
.table th {
  border-top-width: 0px;
  padding: 0 5px !important;
  height: 40px;
  vertical-align: middle !important;
}
.vue-good-table .table td {
  border-bottom: 0;
  max-width: 20px;
}
.fade-enter-active, .fade-leave-active {
    transition: opacity .5s;

}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}
.vue-good-table .table th {
  border-bottom: 1px solid;
  border-color: #5e5e5e !important;
  font-weight: 800;
  color: #5e5e5e;
    white-space: nowrap;
}

.vue-good-table .table tfoot {
  border-top: 1px solid #000000;
}
.vue-good-table .table tfoot td {
  font-weight: 800;
}
.table-responsive::-webkit-scrollbar {
    -webkit-appearance: none;
}
.table-responsive::-webkit-scrollbar:horizontal {
    height: 8px;
}
.table-responsive::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, .5);
    border-radius: 10px;
    border: 2px solid #ffffff;
}
.table-responsive::-webkit-scrollbar-track {
    border-radius: 10px;
    background-color: #ffffff;
}
.table-responsive table th{
	cursor: pointer;
}
tr:nth-child(even) {
  background-color: #f2f2f2;
}
</style>
<script>


export default {
	props: {
		columns: { type: Array, default: () => [] },
		rows: { type: Array, default: () => [] },
		footer: { type: Object, default: () => {} },
		sortBy: { type: Boolean, default: false}
	},
	data() {
		
		return {
			sorted_rows: [],
			column_arrows_index:null,
			column_arrows_sort:'asc',
		};
	},
	computed: {
		table_columns() {
			return this.columns.filter(node=>node.show!==false);
		},
		table_rows() {
			if (this.sortBy) {
				var table_rows = this.rows;
			} else {
			    var table_rows = this.sorted_rows.length ? this.sorted_rows : this.rows;
			}
			return table_rows.length ? table_rows.map(node => {
				return this.formatRow(node, 'row');
			}) : [];
		},
		footer_rows() {
			var footer_rows = this.footer !== undefined ? [this.footer] : [];
			footer_rows = footer_rows.map(node => {
				return this.formatRow(node, 'footer');
			});
			return footer_rows.length ? footer_rows[0] : {};
		},
		column_arrows(){
			return this.columns.map((node,index)=>{
				return index===this.column_arrows_index ? this.column_arrows_sort : 'none';
			});
		}
	},
	mounted(){
		if(this.rows.length && this.sorted_rows.length===0){
			this.sortFunction(this.table_columns[0],0);
		}
	},
	methods: {
		ucfirst(string) {
			return string.charAt(0).toUpperCase() + string.slice(1);
		},
		sortFunction(column, index) {
			if(column.sorting===false){
				return false;
			}
			let type = column.type !== 'undefined' ? column.type : 'string';
			//toggle sorting
			if(this.column_arrows_index === index){
				this.column_arrows_sort = this.column_arrows_sort === 'desc' ? 'asc' :'desc';
			}else{
				this.column_arrows_index = index;
				this.column_arrows_sort = 'asc';
			}
			
			if (this.sortBy) {
				this.$emit('sort', column.field, this.column_arrows_sort, type);
			}

			this.sorted_rows = this.rows.sort(this.compareValues(column.field, this.column_arrows_sort, type));
		},
		sortArrow(key)
		{
			if (this.column_arrows[key]==='asc')
			{
				return  'fa-caret-down';
			}
			else if (this.column_arrows[key]==='desc')
			{
				return  'fa-caret-up';
			}
			else
			{
				return  'fa-sort';
			}
		},
		compareValues(key, order = 'asc', type = 'string') {
			return function(a, b) {
				if (!a.hasOwnProperty(key) || !b.hasOwnProperty(key)) {
					// property doesn't exist on either object
					return 0;
				}
				var varA;
				var varB;
				switch(type){
				case 'string':
					varA = String(a[key]).toUpperCase();
					varB = String(b[key]).toUpperCase();
					break;
				case 'float':
					varA = (Math.round(parseFloat(a[key])*100)/100);
					varB = (Math.round(parseFloat(b[key])*100)/100);
					break;
				default:
					varA = a[key];
					varB = b[key];
				}

				let comparison = 0;
				if (varA ===null || varA ==='') {
					comparison = 1;
				}
				else if (varB ===null || varB ==='') {
					comparison = -1;
				}else{
					if (varA > varB) {
						comparison = 1;
					} else if (varA < varB) {
						comparison = -1;
					}
				}

				return order === 'desc' ? comparison * -1 : comparison;
			};
		},
		formatRow(row, type = 'row') {
			let new_row = {};
			this.columns.map(column => {
				//replace undefined value with empty string
				if (typeof(row[column.field]) === undefined) {
					new_row[column.field] = '';
					return false;
				}
				//check if footerFormat is available in case of footer
				if (type === 'footer') {
					if (
						column.footerFormat === undefined &&
            column.footerFormat !== false
					) {
						new_row[column.field] = row[column.field];
						return false;
					}
				}
				//format row cell w.r.t column field type if given
				if (column.type === 'number') {
					if(row[column.field]){
						new_row[column.field] = parseInt(row[column.field], 10);
					}else {
						new_row[column.field] = '-';
					}
				} else if (column.type === 'float' && row[column.field]) {
					if (typeof column.decimalPoint !== 'undefined') {
						new_row[column.field] = parseFloat(row[column.field]).toFixed(
							column.decimalPoint
						);
					} else {
						new_row[column.field] = parseFloat(row[column.field]).toFixed(2);
					}
				} else if (column.type === 'date' && row[column.field]) {
					if (typeof column.dateFormat !== 'undefined') {
						new_row[column.field] = this.$dayjs(row[column.field]).format(
							column.dateFormat
						);
					} else {
						new_row[column.field] = this.$dayjs(row[column.field]).format(
							'YYYY-MM-DD'
						);
					}
				} else if (column.type === 'percentage') {
					if(row[column.field]!==null){
						new_row[column.field] = parseInt(row[column.field] * 100 ) + '%';
					}else {
						new_row[column.field] = '-';
					}

				} else if (column.type === 'string') {
					if (typeof column.stringFormat !== 'undefined') {
						if (column.stringFormat === 'uppercase') {
							new_row[column.field] = String(row[column.field]).toUpperCase();
						} else if (column.stringFormat === 'ucfirst') {
							new_row[column.field] = this.ucfirst(String(row[column.field]));
						} else {
							new_row[column.field] = String(row[column.field]).toLowerCase();
						}
					} else {
						new_row[column.field] = String(row[column.field]);
					}
				} else {
					new_row[column.field] = row[column.field];
				}
			});
			return Object.assign(Object.assign({}, row), new_row);
		}
	}
};
</script>
