<template>
  <div class="row">
    <div class="col-md-12">
      <classroom-header
        v-if="routeClassroomId" 
        title="Homework"
      />
      <div v-else>
        <h1>Homework</h1>
        <hr>
      </div>
      <div>
        <div class="row">
          <div class="col-md-12">
            <!-- <div class="">
              <div class="col-md-3 col-12 pl-0">
                <div class="mt-2 mb-2">
                  <button
                    type="button"
                    class="btn btn-primary btn-lg "
                    data-toggle="modal"
                    data-target="#addMessageModal"
                  >
                    <i class="fas fa-plus" />&nbsp;&nbsp;Add Message
                  </button>
                </div>
              </div>
              <div class="col-md-3 col-12" />
            </div> -->
            <div class="">
              <!-- <div
                v-if="!messages.length"
                class="card"
              >
                <div class="card-body">
                  <div class="col-md-12">
                    <p>
                      {{ "Currently no message has been added." }}
                    </p>
                  </div>
                </div>
              </div> -->
              <div
                class="card mb-2"
              >
                <div class="card-body">
                  <div>
                    <div class="dashboard_post">
                      <!-- <div class="avatar">
                        <profile-image
                          :avatar="message.avatar_url"
                          :user-name="message.user_name"
                        />
                      </div> -->
                      <div class="info-post ml-2 dash_insititue_name">
                        <p class="font-size-14 mb-0 dash_user_date">
                          Demostudent <span> 10:30am &nbsp; 
                            <!-- <div
                              v-if="message.user_id===AuthUser.id"
                              class="dropdown d-inline"
                            >
                              <button
                                id="dropdownMenuButton"
                                class="btn btn-secondary dropdown-toggle p-0"
                                type="button"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                                <i class="fas fa-ellipsis-v" />
                              </button>
                              <div
                                class="dropdown-menu dropdown-menu-right"
                                style="min-width: max-content;"
                                aria-labelledby="dropdownMenuButton"
                              >
                                <button
                                  type="button"
                                  class="dropdown-item"
                                  data-toggle="modal"
                                  data-target="#editMessageModal"
                                  @click="edit_message=message"
                                >Edit</button> 
                                <button
                                  type="button"
                                  class="dropdown-item"
                                  @click="deleteMessage(message.id)"
                                >Delete</button>
                              </div>
                            </div> --></span> 
                        </p>
                        <p class="font-size-14 mb-0">
                          Java
                        </p>
                      </div>
                    </div>
                    <hr>
                    <p>Your home work for today is answer the following questions <br> Q1)what is your name <br> Q2)How old are you </p>
                  </div>
                  <hr>
                  <button class="btn btn-success">
                    Mark as Done
                  </button>
                </div>
                <div class="col-md-3 col-12" />
              </div>

              <div
                class="card mb-2"
              >
                <div class="card-body">
                  <div>
                    <div class="dashboard_post">
                      <!-- <div class="avatar">
                        <profile-image
                          :avatar="message.avatar_url"
                          :user-name="message.user_name"
                        />
                      </div> -->
                      <div class="info-post ml-2 dash_insititue_name">
                        <p class="font-size-14 mb-0 dash_user_date">
                          Demostudent <span> 10:30am &nbsp; 
                            <!-- <div
                              v-if="message.user_id===AuthUser.id"
                              class="dropdown d-inline"
                            >
                              <button
                                id="dropdownMenuButton"
                                class="btn btn-secondary dropdown-toggle p-0"
                                type="button"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                                <i class="fas fa-ellipsis-v" />
                              </button>
                              <div
                                class="dropdown-menu dropdown-menu-right"
                                style="min-width: max-content;"
                                aria-labelledby="dropdownMenuButton"
                              >
                                <button
                                  type="button"
                                  class="dropdown-item"
                                  data-toggle="modal"
                                  data-target="#editMessageModal"
                                  @click="edit_message=message"
                                >Edit</button> 
                                <button
                                  type="button"
                                  class="dropdown-item"
                                  @click="deleteMessage(message.id)"
                                >Delete</button>
                              </div>
                            </div> --></span> 
                        </p>
                        <p class="font-size-14 mb-0">
                          Java
                        </p>
                      </div>
                    </div>
                    <hr>
                    <p>Your home work for today is answer the following questions <br> Q1)what is your name <br> Q2)How old are you </p>
                  </div>
                  <hr>
                  <button class="btn btn-success">
                    Mark as Done
                  </button>
                </div>
                <div class="col-md-3 col-12" />
              </div>

              <div
                class="card mb-2"
              >
                <div class="card-body">
                  <div>
                    <div class="dashboard_post">
                      <!-- <div class="avatar">
                        <profile-image
                          :avatar="message.avatar_url"
                          :user-name="message.user_name"
                        />
                      </div> -->
                      <div class="info-post ml-2 dash_insititue_name">
                        <p class="font-size-14 mb-0 dash_user_date">
                          Demostudent <span> 10:30am &nbsp; 
                            <!-- <div
                              v-if="message.user_id===AuthUser.id"
                              class="dropdown d-inline"
                            >
                              <button
                                id="dropdownMenuButton"
                                class="btn btn-secondary dropdown-toggle p-0"
                                type="button"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                                <i class="fas fa-ellipsis-v" />
                              </button>
                              <div
                                class="dropdown-menu dropdown-menu-right"
                                style="min-width: max-content;"
                                aria-labelledby="dropdownMenuButton"
                              >
                                <button
                                  type="button"
                                  class="dropdown-item"
                                  data-toggle="modal"
                                  data-target="#editMessageModal"
                                  @click="edit_message=message"
                                >Edit</button> 
                                <button
                                  type="button"
                                  class="dropdown-item"
                                  @click="deleteMessage(message.id)"
                                >Delete</button>
                              </div>
                            </div> --></span> 
                        </p>
                        <p class="font-size-14 mb-0">
                          Java
                        </p>
                      </div>
                    </div>
                    <hr>
                    <p>Your home work for today is answer the following questions <br> Q1)what is your name <br> Q2)How old are you </p>
                  </div>
                  <hr>
                  <button class="btn btn-success">
                    Mark as Done
                  </button>
                </div>
                <div class="col-md-3 col-12" />
              </div>

              <div
                class="card mb-2"
              >
                <div class="card-body">
                  <div>
                    <div class="dashboard_post">
                      <!-- <div class="avatar">
                        <profile-image
                          :avatar="message.avatar_url"
                          :user-name="message.user_name"
                        />
                      </div> -->
                      <div class="info-post ml-2 dash_insititue_name">
                        <p class="font-size-14 mb-0 dash_user_date">
                          Demostudent <span> 10:30am &nbsp; 
                            <!-- <div
                              v-if="message.user_id===AuthUser.id"
                              class="dropdown d-inline"
                            >
                              <button
                                id="dropdownMenuButton"
                                class="btn btn-secondary dropdown-toggle p-0"
                                type="button"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                                <i class="fas fa-ellipsis-v" />
                              </button>
                              <div
                                class="dropdown-menu dropdown-menu-right"
                                style="min-width: max-content;"
                                aria-labelledby="dropdownMenuButton"
                              >
                                <button
                                  type="button"
                                  class="dropdown-item"
                                  data-toggle="modal"
                                  data-target="#editMessageModal"
                                  @click="edit_message=message"
                                >Edit</button> 
                                <button
                                  type="button"
                                  class="dropdown-item"
                                  @click="deleteMessage(message.id)"
                                >Delete</button>
                              </div>
                            </div> --></span> 
                        </p>
                        <p class="font-size-14 mb-0">
                          Java
                        </p>
                      </div>
                    </div>
                    <hr>
                    <p>Your home work for today is answer the following questions <br> Q1)what is your name <br> Q2)How old are you </p>
                  </div>
                  <hr>
                  <button class="btn btn-success">
                    Mark as Done
                  </button>
                </div>
                <div class="col-md-3 col-12" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ClassroomHeader from '../../../components/ClassroomHeader';

export default {
	name:'Homework',
	components:{
		ClassroomHeader,
	},
	data() {
		return {
			routeClassroomId: this.$route.params.classroomId,
			selectedClassroomId: '',
			showLoader: true,
			messages: [],
			content: '',
			edit_message:{
				id:'',
				content:'',
			},
		};
	},

};
</script>

<style>

</style>