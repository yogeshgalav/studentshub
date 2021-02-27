<style scoped>
.mt-100 {
  margin-top: 200px;
}
h1 {
  font-size: 40px;
  margin-top: 3%;
  margin-bottom: 2%;
  color: #6f6f6f;
}
.right {
  text-align: left;
  height: 500px;
  background: black;
  color: azure;
  padding-left: 2%;
  padding: 12% 0 2% 5%;
  font-size: 20px;
}
.mapouter {
  position: relative;
  text-align: right;
  height: 500px;
  width: 100%;
}
.gmap_canvas {
  overflow: hidden;
  background: none !important;
  height: 500px;
  width: 100%;
}
.height {
  height: 500px;
  text-align: center;
  background-color: rgb(34, 32, 32);
  margin-bottom: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
  color: azure;
}
.height h1{
    width: 80%;
    color: azure;
    font-weight: 600;
}
.blank {
  height: 100px;
}
</style>
<template>
  <div>
    <div class="blank"></div>
    <div class="height">
      <h1>
        We help Students, Teachers and Institutes to Find Pain Points and Boost
        Productivity.
      </h1>
    </div>
    <div class="">
      <div class="row" style="background: black">
        <div class="col-6">
          <div class="mapouter">
            <div class="gmap_canvas">
              <iframe
                width="100%"
                height="500"
                id="gmap_canvas"
                src="https://maps.google.com/maps?q=2880%20Broadway,%20New%20York&t=&z=13&ie=UTF8&iwloc=&output=embed"
                frameborder="0"
                scrolling="no"
                marginheight="0"
                marginwidth="0"
              ></iframe
              ><a
                href="https://yt2.org/es/youtube-to-mp3-ALeKk00qEW0sxByTDSpzaRvl8WxdMAeMytQ1611842368056QMMlSYKLwAsWUsAfLipqwCA2ahUKEwiikKDe5L7uAhVFCuwKHUuFBoYQ8tMDegUAQCSAQCYAQCqAQdnd3Mtd2l6"
              ></a
              ><br />
            </div>
          </div>
        </div>
        <div class="col right">
          <p>
            1, Patel Nagar<br />
            22 Godam, Hawa Sadak,<br />
            Jaipur, Rajasthan, 302006
          </p>
          <p>
            Mobile: +91 8003345821<br />
            Email: info@studentshub.in
          </p>
        </div>
      </div>
    </div>

    <main>
      <div class="col-md-12">
        <div class="row justify-content-center">
          <div class="col-md-6 mt-100 p-2">
            <h1>Contact Us</h1>
            <div class="card">
              <div class="card-body">
                <form @submit.prevent="handleSubmit">
                  <div class="form-group row">
                    <label
                      for="Name"
                      class="col-md-4 col-form-label text-md-right"
                      >{{ "Name" }}</label
                    >

                    <div class="col-md-6">
                      <input
                        id="name"
                        ref="name"
                        v-model="name"
                        v-validate="'required|max:30'"
                        type="name"
                        class="form-control"
                        name="name"
                      />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label
                      for="email"
                      class="col-md-4 col-form-label text-md-right"
                      >Email</label
                    >

                    <div class="col-md-6">
                      <input
                        id="email"
                        v-model="email"
                        v-validate="'required|email'"
                        type="email"
                        class="form-control"
                        name="email"
                      />
                      <span class="error">{{ formErrors("email") }}</span>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label
                      for="descrption"
                      class="col-md-4 col-form-label text-md-right"
                      >Description</label
                    >

                    <div class="col-md-6">
                      <textarea
                        id="discription"
                        v-model="description"
                        type="description"
                        class="form-control"
                        name="description"
                        rows="8"
                        cols="80"
                      ></textarea>
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                      <button type="submit" class="btn btn-primary">
                        {{ "Send" }}
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="divider mt-5"></div>
      </div>
      <site-footer />
    </main>
  </div>
</template>

<script>
import FormMixin from "../../components/mixins/form-mixin.js";
import SiteFooter from "../footer/SiteFooter";
export default {
  mixins: [FormMixin],
  name: "contactus",
  components: {
    SiteFooter,
  },
  data() {
    return {
      name: "",
      email: "",
      description: "",
    };
  },
  methods: {
    handleSubmit() {
      this.$validator.validate().then((valid) => {
        if (valid) {
          this.axios
            .post("/api/contactus", {
              name: this.name,
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
