<template>
  <section>
     <!-- <div>{{ post_num }}/10</div> -->
    <!-- <div>{{ followers }}/20</div> -->
    <div>
        <div class="text-center h2 font-weight-bold">
            Studentshub gives you the opportunity to earn
            money by sharing knowledge. If you are a student
            or an educator just create post with education
            content and invite people to follow you.
        </div>
        <div class="row text-center h2 font-weight-bold mt-5">
            <div class="col-lg">
                {{ posts_num }}/10
                <br>
                Posts
            </div>
            <div class="col-lg">
                {{ followers }}/20
                <br>
                Followers
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <button type="button" class="btn btn-primary btn-lg" disabled>Redeem ₹1000</button>
        </div>
        <div class="row justify-content-center mt-3">
            <p class="h2 text-center font-weight-bold">
                Hurry up!   <br>
                Offer valid for limited time.
            </p>
        </div>
        <div class="row justify-content-center h2 mt-4 font-weight-bold">
            <flip-countdown deadline="2018-12-25 00:00:00"></flip-countdown>
        </div>
    </div>
  </section>
</template>
<script>
    import FlipCountdown from 'vue2-flip-countdown';
    export default {
        props:['posts','followers','posts_num'],
        components: { FlipCountdown }
    };
</script>

    