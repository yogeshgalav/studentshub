<template>
  <div class="row">
    <div class="col-md-12 mt-1"> 
      <article>  
        <p>Sport is a human activity involving physical exertion and skill as the primary focus of the activity, with elements of competition or social participation where rules and patterns of behaviour governing the activity exist formally through organisations.</p>
        <p>Sport pertains to any form of competitive physical activity or game[1] that aims to use, maintain or improve physical ability and skills while providing enjoyment to participants and, in some cases, entertainment to spectators.[2] Sports can, through casual or organized participation, improve one's physical health. Hundreds of sports exist, from those between single contestants, through to those with hundreds of simultaneous participants, either in teams or competing as individuals. In certain sports such as racing, many contestants may compete, simultaneously or consecutively, with one winner; in others, the contest (a match) is between two sides, each attempting to exceed the other. Some sports allow a "tie" or "draw", in which there is no single winner; others provide tie-breaking methods to ensure one winner and one loser. A number of contests may be arranged in a tournament producing a champion. Many sports leagues make an annual champion by arranging games in a regular sports season, followed in some cases by playoffs.</p>
        <p>Sport is generally recognised as system of activities based in physical athleticism or physical dexterity, with major competitions such as the Olympic Games admitting only sports meeting this definition.[3] Other organisations, such as the Council of Europe, preclude activities without a physical element from classification as sports. However, a number of competitive, but non-physical, activities claim recognition as mind sports. The International Olympic Committee (through ARISF) recognises both chess and bridge as bona fide sports, and SportAccord, the international sports federation association, recognises five non-physical sports: bridge, chess, draughts (checkers), Go and xiangqi,[4][5] and limits the number of mind games which can be admitted as sports.</p>
        <p>Sport is usually governed by a set of rules or customs, which serve to ensure fair competition, and allow consistent adjudication of the winner. Winning can be determined by physical events such as scoring goals or crossing a line first. It can also be determined by judges who are scoring elements of the sporting performance, including objective or subjective measures such as technical performance or artistic impression.</p>
      </article>
    </div>

    <div 
      v-if="AuthUser.is_pro_member"
    >
      <div class="col-md-12 mt-1">
        <h4>Quality Required</h4>
      </div>
      <hr class="mb-0 mt-0">
      <div class="col-md-12">
        Practical Orientation
        • Good with the particular sport one wish to make
        his/her career in
        • Good Physical Stamina and Mental Strength.
        • Ability to spend long hours in the field during
        Practical application
      </div>
      <div class="col-md-12 mt-1">
        <h4>Entrance Exams</h4>
      </div>
      <hr class="mb-0 mt-0">
      <div class="col-md-12">
        SMAT – UG
        DUET
        IGIPESS-ET
        LNCPE-AT
        GNDU-AT
        BHU-UET
        NSU-AT
        GGSIP - CET
        *Most institutes offering
        admissions in the Sports
        related courses assess the
        candidate on their skill by
        conducting Sports Proficiency
        Test in the respective form of
        sport they wish to take
        admission in and Physical
        Fitness test.
      </div>
      <div class="col-md-12 mt-1">
        <h4>Career Options</h4>
      </div>
      <hr class="mb-0 mt-0">
      <div class="col-md-12">
        You Can be:
        • Announcer
        • Athlete
        • Coach
        • Commentator
        • Equipment Manager
        • Physical Trainer
        • Referee
        • Sports Analyst
        • Sports Manager
        • Stadium Manager

        You can give your service to:
        Indian Army
        Indian Air Force
        Indian Navy
        Indian Coast Guard
        Central Armed Police
        Forces
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