<template>
  <main>
    <div class="space"></div>
    <h3>Frequently Asked Questions</h3>

    <div class="col-md-12">
      <div class="row justify-content-center">
        <div class="col-md-6 mt-100 p-2">
          <div>
            <div class="query">
              <div>
                <label for="email">Email</label>
                <input type="text" id="email" />
              </div>
              <div>
                <label for="question">Query</label>
                <input type="text" id="question" />
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">
                <strong>Q.</strong> How to access portel
              </h5>
              <p class="card-text">
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                sunt in culpa qui officia deserunt mollit anim id est laborum."
              </p>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">
                <strong>Q.</strong> how to reschdule class
              </h5>
              <p class="card-text">
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                sunt in culpa qui officia deserunt mollit anim id est laborum."
              </p>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">
                <strong>Q.</strong> How to get accress to course
              </h5>
              <p class="card-text">
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                sunt in culpa qui officia deserunt mollit anim id est laborum."
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <site-footer />
  </main>
</template>
<style scoped>
.mt-100 {
  margin-top: 150px;
}
strong {
  font-size: 20px;
}
.card {
  margin-top: 20px;
}
.query {
  background: whitesmoke;
  height: 200px;
  padding: 30px;
}
h3 {
  font-size: 24px;
  margin-bottom: -142px;
  margin-top: 4%;
  text-align: center;
}
.query div{
    margin: 10px;
}
.space {
  min-height: 60px;
}
.position {
  position: relative;
}
input {
  width: 100%;
  outline: none;
}
</style>

 <script>
import FormMixin from "../../components/mixins/form-mixin.js";
import SiteFooter from "../footer/SiteFooter";
export default {
  mixins: [FormMixin],
  name: "faq",
  components: {
    SiteFooter,
  },
  data() {
    return {
      email: "",
      description: "",
    };
  },
  methods: {
    handleSubmit() {
      this.$validator.validate().then((valid) => {
        if (valid) {
          this.axios
            .post("/api/faq", {
              email: this.email,
              description: this.description,
            })
            .then((resp) => {
              window.location.href = "/";
            })
            .catch((err) => {});
        }
      });
    },
  },
};
</script>
