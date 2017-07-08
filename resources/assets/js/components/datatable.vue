<template>
	<div>	
		<table :class="props.class" :width="props.width">
            <thead>
                <tr>
                    <th :class="header.class" v-for="header in computedProps.headers" v-text="header.title"></th>
                </tr>
            </thead>
           
        </table>

        <script2 src="/js/datatable.js"></script2>
	</div>
</template>
<script>
import jQuery from 'jquery';
require('datatables');
require('datatables-bootstrap3-plugin'); 

import $style from "../helpers/style";
let style = new $style();

export default{
    props: ['props'],
    data(){
        return {
            table: null,
            tableSelector: null,
        }
    },
    computed:{
        computedProps: function(){
            return this.getProps()
        }
    },
	mounted(){
        // Initialize table
        this.drawTable();
        // inset locale stylesheet
		let locale = this.$i18n.locale() === null ? 'en' : this.$i18n.locale();
		style.pushStyle('/plugins/datatables/plugins/bootstrap/'+ locale +'.css');
	},
	destroyed(){

	},
    methods:{
        drawTable: function(){
            let component = this;
            this.tableSelector = this.$el.querySelector('table');
            this.table = jQuery( this.tableSelector ).DataTable(this.props);
            this.rowClickEvent();
        },
        getProps: function(){
            // index column props
            if(typeof(this.props.index) !== 'undefined'){
                if(this.props.index.present){
                    // Add index to columns
                    this.props.columns.unshift({"data": "DT_Row_Index"});
                    // Add index to headers
                    this.props.headers.unshift({
                        "title": this.props.index.title,
                        "class": this.props.index.class
                    });
                }
            }
            return this.props;
        },
        rowClickEvent: function(){
            let table = this.table;
            let component = this;
            jQuery(this.tableSelector).on('click', 'tr', function(event) {
                let data = table.row( this ).data();
                component.$emit('rowClick', event, data, this);
            });
        }
    },
}
</script>
