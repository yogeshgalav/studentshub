<template>
<div>
<div v-if="0">
      <div
        id="reflection-complete"
        class="card mt-3 mb-3 border-solid border-3px border-radius-12 bg-success border-success"
      >
        <div class="card-header">
          <h3
            class="text-center font-size-18 text-white"
          >
            {{ 'Daily Assisment' }}
          </h3>
        </div>
        <div class="card-body bg-white border-bottom-left-8 border-bottom-right-8">
          <div class="row">
            <div class="col-md-12 col-12 center-col">
              <div class="row">
                <div class="col-md-12 col-lg-12 col-12 text-center">
                  <p>
                    {{'Daily Assisment for today is completed'}}
                    </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      <div
        id="reflection-incomplete"
        class="card mt-3 mb-3 border-solid border-3px border-radius-12 bg-secondary-accent border-secondary-accent"
      >
        <div class="card-header">
          <h3
            class="text-center font-size-18 text-white"
          >
            {{ 'Daily Assisment' }}
          </h3>
        </div>
        <div class="card-body bg-white border-bottom-left-8 border-bottom-right-8">
          <div class="row">
            <div class="col-md-12 col-12 center-col">
              <div class="row">
                <div class="col-md-12 col-lg-12 col-12 text-center">
                  <p>
                    <span class="weight-800 text-accent">
                      {{ 'Daily assisgment for today is remaining' }}
                      </span>
                  </p>
                  <a
                  id="reflection-link"
                    class="btn btn-accent"
                    :href="'/classroom/' + $route.params.classroomId +'/daily-attempt'"
                  >
                    {{ 'Attempt now' }}
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
</template>
<script>

</script>