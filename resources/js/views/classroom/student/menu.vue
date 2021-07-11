<template>
  <div>
    <classroom-header />
    <div class="row">
      <div class="col-md-4">
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
                    {{ 'Attempt or review old assignments' }}
                  </p>
                </div>
              </div>
            </div>
          </router-link>
        </div>
      </div>
      <div class="col-md-4">
        <div class="selection-box-default">
          <router-link
            class="card h-card"
            :to="'/classroom/'+$route.params.classroomId+'/report'"
          >
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12">
                  <h2 class="font-size-18">
                    {{ 'Classroom Report' }}
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

      <div class="col-md-4">
        <div class="selection-box-default">
          <router-link
            class="card h-card"
            :to="'/classroom/'+$route.params.classroomId+'/attendance'"
          >
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12">
                  <h2 class="font-size-18">
                    {{ 'Smart Attendance' }}
                  </h2>
                  <p>
                    {{ 'Mark your presence.' }}
                  </p>
                </div>
              </div>
            </div>
          </router-link>
        </div>
      </div>
      <div class="col-md-4">
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
                    {{ 'View Classroom resources.' }}
                  </p>
                </div>
              </div>
            </div>
          </router-link>
        </div>
      </div>
      <div class="col-md-4">
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
                    {{ 'View classroom messages.' }}
                  </p>
                </div>
              </div>
            </div>
          </router-link>
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
        border-radius: 8px;margin-bottom: 20px;
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
	components:{
		ClassroomHeader
	}
};

</script>
