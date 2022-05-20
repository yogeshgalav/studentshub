<template>
  <div class="card mb-2">
    <div class="card_subject">
      <div class="card-body">
        <div class="row">
          <div class="col-md-8 col-12">
            <p
              v-if="!doubtType"
              class="text-muted font-size-16 mb-0"
            >
              {{ subject.category_name }}
            </p>
            <p
              v-if="!doubtType"
              class="text-blue mt-0 mb-2"
            >
              <span 
                v-for="sub in subject.subjects"
                :key="sub.id"
              >
                #{{ sub.subject_name }}
              </span>
            </p>
          </div>
        </div>
        <hr>
      </div>
    </div>
  </div>
</template>
<script>
export default {
	props:['subject','doubtType'],
	computed:{
		AuthUserId(){
			return this.AuthUser ? this.AuthUser.id : null;
		}
	},
	
};
</script>
