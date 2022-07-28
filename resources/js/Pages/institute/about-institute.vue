<template slot="tab-panel-about">
  <div id="about-html">
    <div class="col-md-10">
      <div title="Blog">
        <div
          v-if="editPermission"
          class="edit-btn-row"
        >
          <button
            v-if="isEdit"
            type="button"
            class="btn btn-primary"
            @click="editBlogDetails()"
          >
            <i
              class="fas fa-pencil-alt"
              style="color: white"
            />
            Edit
          </button>
          <button
            v-else
            type="button"
            class="btn btn-primary"
            @click="submitblog"
          >
            Save 
          </button>
        </div>
        <div>
          <div>
            <div
              v-if="isEdit && institute.blog"
              id="app"
              v-html="institute.blog"
            />
          </div>
          <rich-text-editor
            v-if="!isEdit"
            id="ArticleEditor"
            v-model="institute.blog"
          />
        </div>
      </div>
      <section
        title="Administrators"
        class="card mt-2"
      >
        <div class="card-body ">
          <div
            v-if="editPermission"
            class="edit-btn-row"
            style=" display:flex;
                justify-content:flex-end;"
          >
            <button
              type="button"
              class="btn btn-primary"
              @click="editAdminDetails()"
            >
              <i
                class="fas fa-pencil-alt"
                style="color: white"
              />
              Edit
            </button>
          </div>
          <div v-if="institute_users.length">
            <div style="gap: 40px;">
              <div
                v-for="(
                  instituteuser, index
                ) in institute_users"
                :key="index"
                class="Administrator-profile"
              >
                <div>
                  <img
                    class="intitute-avatar"
                    src="/images/default-avatar.png"
                    alt="Student Hub"
                    width="120"
                    height="120"
                    style=" border-radius: 50%;"
                  >
                </div>
                <div style="font-size: 15px; font-weight:800">
                  {{ instituteuser.user_name }}
                </div>
                <div style="font-size: 15px; font-weight:500">
                  {{ instituteuser.role }}
                </div>
                <div
                  v-if="editPermission"
                  style="height: 30px;"
                >
                  <button
                    v-if="!isEdit"
                    class="btn btn-primary"
                    type="button"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="Delete"
                    @click="
                      deleteInstituteUser(
                        instituteuser
                      ) "
                  >
                    <i class="fa fa-trash" />
                  </button>
                </div>
              </div>
              <div
                v-if="!isEdit"
                class="col-md-2 addAdmin"
              >
                <button
                  v-if="editPermission"
                  class="addAdmin"
                  data-toggle="modal"
                  data-target="#editAdminModal"
                  style=" font-size: 60px;
                          height: 100px;
                          width: 100px;
                          border-radius: 50%;
                          background-color: white;
                        "
                >
                  <i class="fa fa-plus" />
                </button>
              </div>
            </div>
          </div>
          <div v-else>
            <div class="row addAdmin">
              <div
                v-if="editPermission"
                class="col-md-2"
              >
                <button
                  v-if="!isEdit"
                  class="addAdmin"
                  data-toggle="modal"
                  data-target="#editAdminModal"
                  style="font-size: 60px;
                         background-color: white;
                        "
                >
                  <i class="fa fa-plus" />
                </button>
              </div>
            </div>
          </div>
        </div>
        <modal
          id="editAdminModal"
          key="editAdminModal"
          ref="editAdminModal"
          name="editAdminModal"
          class="model"
          heading="Edit Administrator Details"
          @submit="savedetails()"
        >
          <template slot="modalBody">
            <form validationScope="edit_administrator_form">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="full">Full Name</label>
                    <input
                      id="fullName"
                      v-model="name"
                      v-validate="'required'"
                      name="full_name"
                      class="form-control"
                      placeholder="write Full Name here"
                    >
                    <label for="position">Position</label>
                    <input
                      id="postionName"
                      v-model="role"
                      v-validate="'required'"
                      name="position_name"
                      class="form-control"
                      placeholder="write Position Name here"
                    >
                    <label for="admin_phone_no">Phone Number</label>
                    <input
                      id="admin_phone_no"
                      v-model="phone_no"
                      v-validate="'required'"
                      name="admin_phone_no"
                      class="form-control"
                      placeholder="write Admin Phone Number here"
                    >
                    <label>Profile Image</label>
                    <file-upload
                      id="documentUpload"
                      ref="upload"
                      class=" edit-avatar btn btn-primary"
                      post-action="/upload/post"
                      extensions="jpg,jpeg,png"
                      accept="image/*"
                      :drop="true"
                      :size="102 * 1024 * 10"
                      style="width:50%"
                      @input="inputUpdate"
                    >
                      <img
                        src="/images/cam-icon.svg"
                        alt=""
                      >
                      Upload Profile Image
                    </file-upload>
                  </div>
                </div>
              </div>
            </form>
          </template>
        </modal>
      </section>
      <section
        v-if="institute.insta_url"
        title="Instagram mt-2"
      >
        <div class="card-body">
          <div class="col-md-3" />
        </div>
      </section>


      <!-- contact-us section -->

      <section
        title="Contact-Us"
        class="card mt-2"
      >
        <div class="card-body">
          <div
            v-if="editPermission"
            class="edit-btn-row"
          >
            <button
              type="button"
              class="btn btn-primary"
              data-toggle="modal"
              data-target="#addContactModal"
              @click="addContactDetails"
            >
              Add
            </button>
          </div>

          <div
            v-for="(
              institute_contact, index
            ) in institute_contacts"
            :key="index"
            class="row"
          >
            <div class="col-md-3">
              <h5>
                <i class="fas fa-phone-alt" />Department
              </h5>
              <p>
                {{ institute_contact.department }}
              </p>
            </div>
            <div class="col-md-3">
              <h5>
                <i class="fas fa-phone-alt" />Phone
              </h5>
              <p>
                {{ institute_contact.phone_no }}
                <br>
                {{ institute_contact.phone_no2 }}
              </p>
            </div>
            <div class="col-md-4">
              <h5>
                <i class="fas fa-envelope" />Email
              </h5>
              <p>
                {{ institute_contact.email }}
              </p>
            </div>

            <div
              class="contact-btn-col"
              style="margin-bottom:20px"
            >
              <button
                v-if="editPermission"
                type="button"
                class="btn btn-primary"
                data-placement="top"
                title="Edit"
                data-toggle="modal"
                data-target="#addContactModal"
                @click="
                  editContact(
                    institute_contact
                  ) "
              >
                <i
                  class="fas fa-pencil-alt"
                  style="color: white"
                />
                Edit
              </button>
              <button
                v-if="editPermission"
                class="btn btn-primary"
                type="button"
                data-toggle="tooltip"
                data-placement="top"
                title="Delete"
                @click="
                  deleteContact(
                    institute_contact
                  ) "
              >
                <i class="fa fa-trash" />
              </button>
            </div>
          </div>
        </div>
        <modal
          id="addContactModal"
          key="addContactModal"
          ref="addContactModal"
          name="addContactModal"
          class="model-md"
          heading="Add Contact Details"
          @submit="addOrEditContact()"
        >
          <template slot="modalBody">
            <form validationScope="add_contact_form">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input
                      id="email"
                      v-model=" edit_institute_contact.email"
                      v-validate="'required'"
                      name="email"
                      class="form-control"
                      placeholder="write Email here"
                    >
                    <span class="text-danger">{{ formErrors("add_contact_form.email") }}</span>
                    <label for="phone_no">Phone Number</label>
                    <input
                      id="phone_no"
                      v-model="edit_institute_contact.phone_no"
                      v-validate="'required'"
                      name="phone_no"
                      class="form-control"
                      placeholder="write Phone Number here"
                    >
                    <span class="text-danger">
                      {{ formErrors( "add_contact_form.phone_no") }}
                    </span>
                    <label for="phone_no2">Phone Number2</label>
                    <input
                      id="phone_no2"
                      v-model=" edit_institute_contact.phone_no2 "
                      name="phone_no2"
                      class="form-control"
                      placeholder="write Phone Number here"
                    >

                    <!-- <label for="whatsapp_no">WhatsApp Number</label>
                    <input
                      id="phone_no2"
                      v-model=" edit_institute_contact.whatsapp_no "
                      name="whatsapp_no"
                      class="form-control"
                      placeholder="write Whatsapp Number here"
                    > -->

                    <label for="department">Department Name</label>
                    <input
                      id="department"
                      v-model=" edit_institute_contact.department"
                      name="department"
                      class="form-control"
                      placeholder="write Department Name here"
                    >
                  </div>
                </div>
              </div>
            </form>
          </template>
        </modal>
      </section>


      <!-- location section -->
      <section
        v-if="institute.longitude && institute.latitude"
        title="Location"
        class="mt-2"
      >
        <div>
          <div class="flex">
            <div class="col-12">
              <div class="mapouter">
                <div class="gmap_canvas">
                  <iframe
                    id="gmap_canvas"
                    class="map-location"
                    width="100%"
                    height="500px"
                    src="https://maps.google.com/maps?q=26.9024375%2075.78706249999999&t=&z=16&ie=UTF8&iwloc=&output=embed"
                  />
                  <a
                    href="https://yt2.org/youtube-to-mp3-ALeKk00qEW0sxByTDSpzaRvl8WxdMAeMytQ1611842368056QMMlSYKLwAsWUsAfLipqwCA2ahUKEwiikKDe5L7uAhVFCuwKHUuFBoYQ8tMDegUAQCSAQCYAQCqAQdnd3Mtd2l6"
                  />
                  <br>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>


<script>
// import Accordion from '@/components/accordion.vue';
import FileUpload from 'vue-upload-component';
import Modal from '../../components/VueNiceModal.vue';
import FormMixin from '../../components/mixins/form-mixin.js';
import RichTextEditor from '../../components/RichTextEditor';

export default {
	components: {
		FileUpload,
		Modal,
		RichTextEditor,
	},
	mixins: [FormMixin],
	props:['institute', 'editPermission'],

 

	data() {
		return {
			institute_users: [],
			institute_contacts: [],
			edit_institute: {
				website: '',
				address: '',
				moto: '',
			},
			edit_institute_contact: {
				email: '',
				phone_no: '',
				phone_no2: '',
			},
			// user_id: '',
			 role: '',
			 phone_no: '',
			 name: '',

  
			showLoader: true,
			// selected_institute: {
			//   id: null,
			//   name: '',
			// },
			isEdit: true,
			new_blog: '',
		};
	},

	mounted() {
		this.loadInstituteusers();
	},

	methods: {
		loadInstituteusers() {
			this.axios
				.get('/api/instituteusers/' + this.institute.id)
				.then((resp) => {
					this.institute_users = resp.data.success.institute_users;
					this.institute_contacts = resp.data.success.institute_contacts;
				});
		},
		addContactDetails() {
			this.edit_institute_contact.email = '';
			this.edit_institute_contact.phone_no = '';
			this.edit_institute_contact.phone_no2 = '';
		},

		addOrEditContact() {
			this.validateForm('add_contact_form').then((valid) => {
				console.log(valid);
				if (valid) {
					this.contactCreateOrUpdateApi();
				}
			});
		},
		contactCreateOrUpdateApi() {
			let loader = this.$loading.show();
			this.axios
				.post(this.baseUrl + '/api/add-contact', {
					email: this.edit_institute_contact.email,
					phone_no: this.edit_institute_contact.phone_no,
					phone_no2: this.edit_institute_contact.phone_no2,
					department: this.edit_institute_contact.department,
					edit_institute_contact_id: this.edit_institute_contact.id,
				})
				.then((resp) => {
					loader.hide();
					this.$refs.addContactModal.closeModal();
					this.edit_institute_contact.push({
						email: resp.data.success.institute_contacts.email,
						phone_no: resp.data.success.institute_contacts.phone_no,
						phone_no2: resp.data.success.institute_contacts.phone_no2,
						department: resp.data.success.institute_contacts.department,
						id: resp.data.success.institute_contacts.id,
					});
					this.clearModalData();
				});
		},


		editContact(edit_institute_contact) {
			this.edit_institute_contact = edit_institute_contact;
		},
		deleteContact(edit_institute_contact) {
			let loader = this.$loading.show();
			this.axios
				.delete('/api/contact/' + edit_institute_contact.id)
				.then((resp) => {
					loader.hide();
					let index = this.institute_contacts.findIndex(
						(el) => el.id === edit_institute_contact.id
					);
					this.institute_contacts.splice(index, 1);
				});
		},

		editAdminDetails() {
			this.isEdit = false;
		},

		savedetails() {
			this.showLoader = true;
			this.axios
				.post(this.baseUrl + '/api/add-details', {
					name: this.name,
					user_id: this.user_id,
					role: this.role,
					phone_no: this.phone_no,
				})
				.then((resp) => {
					this.showLoader = false;
					this.institute_users.push({
						name: resp.data.success.institute_user.name,
						institute_id:
              resp.data.success.institute_user.institute_id,
						user_id: resp.data.success.institute_user.user_id,
						role: resp.data.success.institute_user.role,
						phone_no: resp.data.success.institute_user.phone_no,
						id: resp.data.success.institute_user.id,
					});
				});
			this.$refs.editAdminModal.closeModal();
			this.clearModalData();
		},
		deleteInstituteUser(instituteuser) {
			let loader = this.$loading.show();
			this.axios
				.delete('/api/instituteuser/' + instituteuser.id)
				.then((resp) => {
					loader.hide();
					let index = this.institute_users.findIndex(
						(el) => el.id === instituteuser.id
					);
					this.institute_users.splice(index, 1);
				});
		},

		editBlogDetails() {
			this.isEdit = false;
		},

		submitblog() {
			let loader = this.$loading.show();
			this.axios.post('/api/update-institute-blog/' + this.institute.id, {
				new_blog: this.institute.blog,
			})
				.then(resp => {
					this.institute.blog = resp.data.success.blogs;
					loader.hide();
				});
		},
		clearModalData() {
			this.name = '';
			this.role = '';
			this.id = '';
		},
		//   addAdministrator() {
		//     this.$modal.show('editAdminModal');
		//   },
	
	},



};
</script>