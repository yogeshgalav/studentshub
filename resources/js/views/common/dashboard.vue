<template>
  <main>
    <div class="container pt-100">
      <div class="col-md-8 center-col">
        <div class="row">
          <div class="col-md-12">
            <div class="card mb-3">
              <div class="card-body">
                <a class="h-card" :href="AuthUserType==='student'?'/share-your-knowledge':'/education-details'"> 
                <img src="/images/knowledge.svg" alt="">&emsp;
                Share Your Knowledge &emsp;<span><i class="fa fa-arrow-right" aria-hidden="true"></i></span>  
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <home-post-container></home-post-container>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>
<style scoped>
.main-habit-builder {
  margin: auto;
}

.main-habit-builder .btn-default {
  background: #fff !important;
  box-shadow: 2px 2px 2px #bbbbcc;
  border: 1px solid #eee;
  font-size: 17px;
  color: #bbbbcc !important;
  font-weight: bold;
  margin-right: 20px;
  margin-bottom: 5px;
}
.share {
  position: fixed;
  z-index: 999;
}
.main-habit-builder input {
  color: #bbbbcc;
}

.main-habit-builder .card {
  padding: 20px !important;
}

.main-habit-builder h2 {
  font-size: 36px;
  font-weight: 600;
  color: #000;
}

.main-habit-builder p {
  font-weight: bold;
  color: #000;
  margin: 2px 0px 2px 0px;
}
</style>

<script>
import HomePostContainer from "../post-containers/HomePostContainer";

export default {
  components: {
    HomePostContainer
  },
  data() {
    return {};
  },
  methods: {
    trans: function(string, defaultString) {
      return this.$trans("home", string, defaultString);
    }
  }
};
</script>
