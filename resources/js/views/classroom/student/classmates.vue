<template>
  <div>
    <div class="col-md-12">
      <h1>Classmates</h1>
    </div>
    <hr>
    <div class="col-md-10 col-sm-12">
      <div class="classmate card">
        <div class="row">
          <div class="text-center col-md-3">
            <!-- <a
                    :href="'/classroom/' + classroom.id"
                    class="card rounded-lg pt-3 pb-3 bg-light  text-center"
                    style="text-center"
                > -->
            <div style="text-align: -webkit-center">
              <profile-image
                :user-name="'M'"
                size="large"
              />
            </div>

            <h4 class="mt-2 font-weight-normal text-muted">
              Teacher Name
            </h4>

            <!-- </a> -->
          </div>
          <div class="col-md-7 mt-2 mb-1">
            <div class="progress-section mb-1">
              <div class="progress-desc">
                <div class="progress-bar-haeding">
                  Anything
                </div>
                <div class="progress-bar-percent">
                  50%
                </div>
              </div>
              <div class="progress-bar-limit">
                <div class="progress" />
              </div>
            </div>
            <div class="progress-section mb-1">
              <div class="progress-desc">
                <div class="progress-bar-haeding">
                  Anything
                </div>
                <div class="progress-bar-percent">
                  50%
                </div>
              </div>
              <div class="progress-bar-limit">
                <div class="progress" />
              </div>
            </div>
            <div class="progress-section mb-1">
              <div class="progress-desc">
                <div class="progress-bar-haeding">
                  Anything
                </div>
                <div class="progress-bar-percent">
                  50%
                </div>
              </div>
              <div class="progress-bar-limit">
                <div class="progress" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.card {
    padding: 20px 10px;
}
.row {
    display: flex;
    align-items: center;
    justify-content: space-evenly;
}
.classmates-section {
    margin: auto;
}
.progress-section {
    margin: 2px 1px;
}
.progress-desc {
    display: flex;
    justify-content: space-between;
    flex-wrap: nowrap;
    align-items: center;
}
.progress-bar-limit {
    width: 100%;
    height: 10px;
    background-color: rgb(231, 231, 231);
    border-radius: 10px;
}
.progress {
    height: 100%;
    width: 50%;
    background-color: rgb(255, 0, 0);
}
</style>
<script>
export default {
	mounted(){
		this.axios.get('/api/classmates');
	}
};
</script>
