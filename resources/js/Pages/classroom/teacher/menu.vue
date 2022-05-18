<template>
  <div class="row">
    <div class="col-md-12">
      <classroom-header />
      <div class="row">
        <div class="col-md-4 mb-3">
          <div class="selection-box-default">
            <router-link
              class="card h-card"
              :href="'/classroom/'+classroom.id+'/overview'"
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
              :href="'/classroom/'+classroom.id+'/attendance'"
            >
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12">
                    <h2 class="font-size-18">
                      {{ 'Smart Attendance' }}
                    </h2>
                    <p>
                      {{ 'check presence of students.' }}
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
              :href="'/classroom/'+classroom.id+'/homeworks'"
            >
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12">
                    <h2 class="font-size-18">
                      {{ 'Homework' }}
                    </h2>
                    <p>
                      {{ 'Checkout your homework.' }}
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
              :href="'/classroom/'+classroom.id+'/setup'"
            >
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12">
                    <h2 class="font-size-18">
                      {{ 'Unit Planning' }}
                    </h2>
                    <p>
                      {{ 'Plan your subject in units.' }}
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
              :href="'/classroom/'+classroom.id+'/daily-assignment'"
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
              :href="'/classroom/'+classroom.id+'/report'"
            >
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12">
                    <h2 class="font-size-18">
                      {{ 'Report' }}
                    </h2>
                    <p>
                      {{ 'View classroom report.' }}
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
              :href="'/subject/'+classroom.subject_id+'#posts'"
            >
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12">
                    <h2 class="font-size-18">
                      {{ 'Posts' }}
                    </h2>
                    <p>
                      {{ 'Add or explore posts from this subject.' }}
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
              :href="'/subject/'+classroom.subject_id+'#doubts'"
            >
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12">
                    <h2 class="font-size-18">
                      {{ 'Posts' }}
                    </h2>
                    <p>
                      {{ 'Add or explore doubts from this subject.' }}
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
import ClassroomHeader from '../../../components/ClassroomHeader';
export default {
	components: {
		ClassroomHeader
	},
	props:['classroom'],
	data() {
		return {};
	},
};

</script>
