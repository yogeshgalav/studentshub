<template>
  <div class="row">
    <div class="col-md-12">
      <classroom-header />
      <div class="row">
        <div class="col-md-4 mb-3">
          <div class="selection-box-default">
            <router-link
              class="card h-card"
              :to="'/classroom/'+$route.params.classroomId+'/overview'"
            >
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12">
                    <h2 class="font-size-18">
                      {{ 'Overview' }}
                    </h2>
                    <p>
                      {{ 'overview' }}
                    </p>
                  </div>
                </div>
              </div>
            </router-link>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="selection-box-default">
            <router-link
              class="card h-card"
              :to="'/classroom/'+$route.params.classroomId+'/students'"
            >
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12">
                    <h2 class="font-size-18">
                      {{ 'Students' }}
                    </h2>
                    <p>
                      {{ 'Students details and join requests.' }}
                    </p>
                  </div>
                </div>
              </div>
            </router-link>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="selection-box-default">
            <router-link
              class="card h-card"
              :to="'/classroom/'+$route.params.classroomId+'/setup'"
            >
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12">
                    <h2 class="font-size-18">
                      {{ 'Unit Setup' }}
                    </h2>
                    <p>
                      {{ 'Divide your subject in units.' }}
                    </p>
                  </div>
                </div>
              </div>
            </router-link>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="selection-box-default">
            <router-link
              class="card h-card"
              :to="'/classroom/'+$route.params.classroomId+'/daily-assignment'"
            >
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12">
                    <h2 class="font-size-18">
                      {{ 'Daily Assignment' }}
                    </h2>
                    <p>
                      {{ 'Create daily assignment test for students.' }}
                    </p>
                  </div>
                </div>
              </div>
            </router-link>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="selection-box-default">
            <router-link
              class="card h-card"
              :to="'/classroom/'+$route.params.classroomId+'/daily-report'"
            >
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12">
                    <h2 class="font-size-18">
                      {{ 'Daily Report' }}
                    </h2>
                    <p>
                      {{ 'Daily assignment report for attempted tests.' }}
                    </p>
                  </div>
                </div>
              </div>
            </router-link>
          </div>
        </div>
         
        <div class="col-md-4 mb-3">
          <div class="selection-box-default">
            <router-link
              class="card h-card"
              :to="'/classroom/'+$route.params.classroomId+'/unit-assignment'"
            >
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12">
                    <h2 class="font-size-18">
                      {{ 'Unit Assignment' }}
                    </h2>
                    <p>
                      {{ 'Coming soon...' }}
                    </p>
                  </div>
                </div>
              </div>
            </router-link>
          </div>
        </div>       
        <div class="col-md-4 mb-3">
          <div class="selection-box-default">
            <router-link
              class="card h-card"
              :to="'/classroom/'+$route.params.classroomId+'/resources'"
            >
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12">
                    <h2 class="font-size-18">
                      {{ 'Resources' }}
                    </h2>
                    <p>
                      {{ 'Add document or video links.' }}
                    </p>
                  </div>
                </div>
              </div>
            </router-link>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="selection-box-default">
            <router-link
              class="card h-card"
              :to="'/classroom/'+$route.params.classroomId+'/messages'"
            >
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12">
                    <h2 class="font-size-18">
                      {{ 'Message' }}
                    </h2>
                    <p>
                      {{ 'Add Message for classroom.' }}
                    </p>
                  </div>
                </div>
              </div>
            </router-link>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="selection-box-default">
            <router-link
              class="card h-card"
              :to="'/classroom/'+$route.params.classroomId+'/doubts'"
            >
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12">
                    <h2 class="font-size-18">
                      {{ 'Doubts' }}
                    </h2>
                    <p>
                      {{ 'Answer Doubts.' }}
                    </p>
                  </div>
                </div>
              </div>
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style lang="scss">
    @import 'resources/sass/_variables.scss';

    .selection-box-default {

        display: flex;
        height: 100%;
        width: 100%;
       
    }

    .selection-box-default a {
        width: 100%;
    }

    .selection-box-default .card {
        box-shadow: 0 2px 50px rgba(0, 0, 0, 0.15);
        cursor: pointer;
        border: 4px solid transparent;
        border-radius: 8px;
    }
 
    .selection-box-default:hover a {
        text-decoration: none;
    }

    .selection-box-default p {
        color: $secondary2-color;
    }

    @media screen and (max-width: 768px) {

        .selection-box-default p,
        .selection-box-default h2 {
            text-align: center;
        }
    }

</style>
<script>
import ClassroomHeader from '../../components/ClassroomHeader';
export default {
	components: {
		ClassroomHeader
	},
	data() {
		return {};
	},
};

</script>
