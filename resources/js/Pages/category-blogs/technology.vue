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
      <div class="col-md-12 p-4">
        <ul class="lisi-group">
          <li class>
            Academic Orientation
          </li>
          <li class>
            Good with Mathematics and Sciences with affinity towards Technology
          </li>
          <li class>
            Interest in latest Machines, Gadgets and repairing
            things Etc.
          </li>
          <li class>
            Ability to spend long hours with books and/or computers during study and in the field during
            Practical application
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
              JEE-MAIN / ADVANCED
            </li>
            <li class>
              BITSAT (Birla)
            </li>
            <li class>
              VITEEE (Vellore)
            </li>
            <li class>
              SITEEE (Symbiosis)
            </li>
            <li class>
              SRMJEE
            </li>
            <li class>
              NPAT (Narsee Monjee)
            </li>
            <li class>
              MET (Manipal)
            </li>
            <li class>
              KIIT-EE (Kalinga)
            </li>
          </ul>
          <ul>
            <h5>You Can be:</h5>
            <li class>
              UPES-EAT
            </li>
            <li class>
              GAT (Gitam)
            </li>
            <li class>
              GUJ-CET
            </li>
            <li class>
              MHT-CET
            </li>
            <li class>
              KEA-CET
            </li>
            <li class>
              TS-EAMCET
            </li>
            <li class>
              AP-EAMCET
            </li>
            <li class>
              WB-JEE
            </li>
          </ul>
        </div>
      </div>
      <div class="col-md-12 mt-1">
        <h4>Career Options</h4>
      </div>
      <hr class="mb-0 mt-0">
      <div class="col-md-12 p-2">
        <div class="d-flex pt-2 w-50 justify-content-between">
          <ul>
            <h5>You Can be Engineer in field of:</h5>
            <li class>
              Aerospace
            </li>
            <li class>
              Aeronautical
            </li>
            <li class>
              Aircraft Maintenance
            </li>
            <li class>
              Automobile
            </li>
            <li class>
              Biochemical
            </li> 
            <li class>
              Biological Sciences
            </li> 
            <li class>
              Biomedical
            </li> 
            <li class>
              Ceramic
            </li>
            <li class>
              Chemical
            </li> 
            <li class>
              Civil
            </li> 
            <li class>
              Electrical
            </li>
            <li class>
              Electronics
            </li> 
            <li class>
              Electronics & Communication
            </li>
            <li class>
              Electronics & Electrical
            </li> 
            <li class>
              Electronics & Instrumentation
            </li>
            <li class>
              Engineering Physics
            </li>
            <li class>
              Engineering Science
            </li>
            <li class>
              Environmental
            </li> 
            <li class>
              Fire Technology
            </li> 
            <li class>
              Food & Nutrition
            </li>
          </ul>
          <ul>
            <h5>You Can be Engineer in field of:</h5>

            <li class>
              Instrumentation
            </li>
            <li class>
              Leather Technology
            </li>
            <li class>
              Manufacturing Science
            </li>
            <li class>
              Marine
            </li>
            <li class>
              Material Science
            </li>
            <li class>
              Mathematics & Computing
            </li>
            <li class>
              Mechanical
            </li>
            <li class>
              Mechatronics
            </li>
            <li class>
              Metallurgical
            </li>
            <li class>
              Mineral
            </li>
            <li class>
              Mining
            </li>
            <li class>
              Mining Machinery
            </li>
            <li class>
              Naval Petrochemical
            </li>
            <li class>
              Petroleum
            </li>
            <li class>
              Plastic
            </li>
            <li class>
              Polymer
            </li>
            <li class>
              Production
            </li>
            <li class>
              Robotics & Textile
            </li>
            <li class>
              Food Technology
            </li> 
            <li class>
              Genetic
            </li> 
            <li class>
              Geoinfomatics
            </li> 
            <li class>
              Industrial & Systems
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
	components :{
	}
};
</script>