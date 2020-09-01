<template>
    <div class="col-md-12">
         <button 
            class="btn btn-success" 
            type="button"
            @click="$modal.show('add_member')"
            >Add Member</button>
            <modal name="add_member" class="doubt_model">
            <form>
                <div class="model_box_inner card p-0">
                    <div class="card-header">
                         <div class="edit_profile_head">
                                <h4>Add Member</h4>
                            </div> 
                    </div>
                    <div class="row card-body">
                        <div class="col-md-12">
                            <div class="model_input">
                                <label class="text-gray">Enter Name</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                      <div class="col-md-12">
                            <div class="model_input">
                                <label class="text-gray">Enter Email</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                           <div class="col-md-12">
                            <div class="model_input">
                                <label class="text-gray">Password</label>
                                <input type="password" class="form-control">
                            </div>
                        </div>
                             <div class="col-md-12">
                            <div class="model_input">
                              <select class="form-control">
                                <option>Select Role</option>
                                <option>Teacher</option>
                                <option>Admin</option>
                                <option>Staff</option>

                              </select>
                            </div>
                        </div>
                   <div class="col-md-12">
                             <button 
            class="btn btn-primary" 
            type="button"
           
            >Add Member</button>
                   </div>
                    </div>
                </div>
            </form>
            </modal>
    </div>
   
</template>
 <script>
 import VModal from 'vue-js-modal';
import swal from '../../components/swal';
     export default {
         components:{
            VModal
        },
     }
    </script>