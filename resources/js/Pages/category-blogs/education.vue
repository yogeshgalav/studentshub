<template>
  <div class="row">
    <div class="col-md-12 mt-1"> 
      <article>  
        <p>Education is the process of facilitating learning, or the acquisition of knowledge, skills, values, morals, beliefs, habits, and personal development.  It is the act or process of imparting or acquiring general knowledge, developing the powers of reasoning and judgment, and generally of preparing oneself or others intellectually for mature life. Education brings about an inherent and permanent change in a person's thinking and capacity to do things. </p>
        <p>Educational methods include teaching, training, storytelling, discussion and directed research. Education frequently takes place under the guidance of educators; however, learners can also educate themselves. Education can take place in formal or informal settings, and any experience that has a formative effect on the way one thinks, feels, or acts may be considered educational. The methodology of teaching is called pedagogy. Formal education is commonly divided formally into stages such as preschool or kindergarten, primary school, secondary school and then college, university, or apprenticeship. In most regions, education is compulsory up to a certain age. There are movements for education reforms, such as for improving quality and efficiency of education towards relevance in students' lives and efficient problem solving in modern or future society at large, or for evidence-based education methodologies. A right to education has been recognized by most of the governments and hence can be classified as basic human need.</p>
      </article>
    </div>
  
    <div 
      v-if="AuthUser.is_pro_member"
      class="row"
    >
      <div class="col-md-12 mt-1">
        <h4>Quality Required</h4>
      </div>
      <hr class="mb-0 mt-0">
      <div class="col-md-12 p-2">
        <ul>
          <li class>
            Academic, People and Creative Orientation.
          </li>
          <li class>
            Good with Languages and Social Sciences with affinity towards extra and versatile reading.
          </li>
          <li class>
            Interest in studying various subjects related to Humanities, Commerce, Management, Sciences and
            Performing Arts.
          </li>
          <li class>
            Wishing to choose your own subjects and study what you like.
          </li>
        </ul>
      </div>
      <div class="col-md-12 mt-1">
        <h4>Entrance Exams</h4>
      </div>
      <hr class="mb-0 mt-0">
      <div class="col-md-12 p-2">
        <div class="d-flex pt-2 w-50 justify-content-between">
          <ul>
            <h5>You Can be:</h5>
            <li class>
              FEAT (Flame-Pune)
            </li>
            <li class>
              AAT (Ashoka)
            </li>
            <li class>
              SET (Symbiosis)
            </li>
            <li class>
              PDPU-AT
            </li>
            <li class>
              NPAT (Narsee Monjee)
            </li>
          </ul>
          <ul>
            <h5>You Can be:</h5>
            <li class>
              KUAT (Karnavati)
            </li>
            <li class>
              KREA-ET
            </li>
            <li class>
              JSAT (Jindal)
            </li>
            <li class>
              SRM-ET
            </li>
          </ul>
        </div>
      </div>
      <div class="col-md-12 mt-1">
        <h4>Career Options</h4>
      </div>
      <hr class="mb-0 mt-0">
      <div class="col-md-12">
        <div class="d-flex pt-2 w-50 justify-content-between">
          <ul>
            <h5>You Can be:</h5>
            <li class>
              Banking or retail management trainee
            </li>
            <li class>
              Buyer trainee
            </li>
            <li class>
              Claims adjuster
            </li>
            <li class>
              Underwriter
            </li>
            <li class>
              College/university admission counselor
            </li>
            <li class>
              Convention/meeting planner
            </li>
            <li class>
              Development officer/fundraiser
            </li>
          </ul>
          <ul>
            <h5>You Can be:</h5>
            <li class>
              Human resources professional
            </li>
            <li class>
              Insurance agent
            </li>
            <li class>
              Management
            </li>
            <li class>
              Public relations specialist
            </li>
            <li class>
              Sales representative
            </li>
            <li class>
              Teacher
            </li>
            <li class>
              Writer
            </li>
            <li class>
              Intelligence Officer/Analyst
            </li>
          </ul>
        </div>
      </div>
    
      <accordion
        title="Literature"
        class="mb-2"
      >
        <p>Literature is an art form that shares stories. It is an art form of language and can be read or spoken. The Concise Oxford Dictionary defines literature as “writings whose value lies in the beauty of form or emotional effect.”</p>
        <p>Literature crosses all written languages and encompasses a wide range of written works, including poetry, essays, plays, biographies, fiction, non-fiction, satires, and more.</p>
        <p>Writers create art with literature through the organization of words that give pleasure, and while reading is enjoyable, those words are often critiques of society. Many of the most well-known authors used language and the written word to critique or offer a point of view on society, including George Orwell, Charlotte Brontë, and Charles Dickens.</p>
        <p>While literature stands on its own as an art form and is one of the seven different forms of art, it is also closely related to theater, poetry, film, music, and the spoken word.</p>
      </accordion>
    </div>
  </div>
</template>
<script>
export default {
	components :{
	}
};
</script>