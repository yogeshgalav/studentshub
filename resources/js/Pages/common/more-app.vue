<template>
  <div>
    <Head>
      <title> More Apps</title>
    </Head>
    <div
      v-for="(app,index) in apps"
      :key="app.id"
      class="row"
    >
      <div class="col-md-12">
        <p class="weight-800 font-size-24 text-black">
          {{ index+1 }}. {{ ' ' }}

          <a
            target="_blank"
            class="weight-800 font-size-24 text-blue"
            :href="app.link"
          >{{ app.name }}</a>
        </p>
      </div>
      <div class="col-md-12 mt-0 mb-2">
        <p class="font-size-18">
          {{ app.description }}
        </p>
      </div>
    </div>
  </div>
</template>
<script>
export default {
	props:['apps']
};
</script>