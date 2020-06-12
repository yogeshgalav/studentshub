<template>
  <div>
    <div class="container-fluid generate-habit-builder">
      <div class="row">
        <div class=" col-md-12">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <h2 class="font-size-40 text-black weight-800 mb-0">
                  {{ classroom ? classroom.name : 'Classroom Name' }}
                </h2>
                <p class="font-size-18 text-black mb-1">
                  <span> {{ 'Teacher:' }}: {{ classroom.teacher_name }}  </span>
                </p>
                <h3 class="text-blue font-size-24 weight-800">
                  {{ 'Classroom Join Id :' }}: {{ classroom.join_id }}
                </h3>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <NavTabs
                  size="large"
                  :tabs="tabs"
                  :initial-tab="initialTab"
                >
                  <template slot="tab-heading-Create">
                    {{ 'Create' }}
                  </template>
                  <template slot="tab-panel-Create">
                    
                  </template>
                  <template slot="tab-heading-Students">
                    {{ 'Students' }}
                  </template>
                  <template slot="tab-panel-Students">
                    
                  </template>
                </NavTabs>
              </div>
            </div>
            <div class="divider1 mt-2 mb-2" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
    
}
</script>