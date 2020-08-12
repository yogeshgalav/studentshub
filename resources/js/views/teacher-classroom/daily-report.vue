
<template>
     <div>
          <!--Answered Daily Assignment -->
         <div class="card-body">
                      <div class="row">
                        <div
                          v-if="daily_questions.length"
                          class="col-md-4"
                        >
                          <h5
                            class="text-black weight-800"
                          >
                            {{ 'Daily Questions' }} 
                          </h5>
                          <ul>
                            <li
                              v-for="(question,index) in daily_questions"
                              :key="index"
                              class="mb-3"
                            >
                              <p
                                class="text-light-gray1 weight-800 mb-0"
                              >
                                {{ $t('vue-commitment-dashboard.question') }} {{ index+1 }}
                              </p>
                              <div class="mb-1">
                                <span class="weight-800 text-color">Q:</span>
                                {{ question.question_text }}
                              </div>
                              <div>
                                <span class="weight-800 text-color">A:</span>
                                {{ question.correct_answer }}
                              </div>
                            </li>
                          </ul>
                        </div>
                      </div>
         </div>
     </div>
</template>
<script>
export default {
    
}
</script>