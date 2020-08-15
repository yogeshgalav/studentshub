import Vue from 'vue';
import VueSweetalert2 from 'vue-sweetalert2';

Vue.use(VueSweetalert2);
export default { 
    infoDialog: function(text){
        const swalWithBootstrapButtons = Vue.swal.mixin({});
        return new swalWithBootstrapButtons({
            text: text,
        });
    },
    successDialog: function(title,text,type){
        const swalWithBootstrapButtons = Vue.swal.mixin({});
        return new swalWithBootstrapButtons({
            title: title,
            text: text,
            type: type,
            showCancelButton: false,
            showConfirmButton: false,
        });
    },
    confirmDialog: function(title="Are you sure?",text="You wont be able to revert this change",type="warning"){
        const swalWithBootstrapButtons = Vue.swal.mixin({
            confirmButtonClass: 'btn btn-success float-right btn-lg mr-1',
            cancelButtonClass: 'btn btn-danger floar-left  btn-lg btntext-danger',
            buttonsStyling: false,
        });
        return new swalWithBootstrapButtons({
                title: title,
                text: text,
                type: type,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm'
            });
        },
    alertDialog: function(title="Are you sure?",text="You wont be able to revert this change",type="warning"){
        const swalWithBootstrapButtons = Vue.swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
        });
        return new swalWithBootstrapButtons({
            title: title,
            text: text,
            type: type,
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK'
        });
    },
    errorDialog: function(title='Oops...',text){
        const swalWithBootstrapButtons = Vue.swal.mixin({});
        return new swalWithBootstrapButtons({
            text: text,
            title: title,
            type: 'error',
        });
    }
    
}
