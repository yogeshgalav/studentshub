<template>
    <div class="full-size">
        <div class="classmates-section col-md-7 col-sm-12">
            <div class="classmate card mb-2">
                <div class="row">
                    <div class="text-center col-md-12 notification">
                        <!-- <a
                    :href="'/classroom/' + classroom.id"
                    class="card rounded-lg pt-3 pb-3 bg-light  text-center"
                    style="text-center"
                > -->
                        <div style="text-align: -webkit-center" class=" pl-0">
                            <profile-image :user-name="'M'" size="large" />
                        </div>

                        <!-- </a> -->
                        <div class="notification-text">
                            teacher has created daily assignment has created
                            daily assignmenthas created daily assignment
                        </div>
                        <div class="time-gap text-grey">
                            12 hours ago
                        </div>
                    </div>
                </div>
            </div>

            <div class="classmate card mb-2">
                <div class="row">
                    <div class="text-center col-md-12 notification">
                        <!-- <a
                    :href="'/classroom/' + classroom.id"
                    class="card rounded-lg pt-3 pb-3 bg-light  text-center"
                    style="text-center"
                > -->
                        <div style="text-align: -webkit-center" class=" pl-0">
                            <profile-image :user-name="'M'" size="large" />
                        </div>

                        <!-- </a> -->
                        <div class="notification-text">
                            teacher has created daily assignment has created
                            daily assignmenthas created daily assignment
                        </div>
                    </div>
                </div>
            </div>

            <div class="classmate card mb-2">
                <div class="row">
                    <div class="text-center col-md-12 notification">
                        <!-- <a
                    :href="'/classroom/' + classroom.id"
                    class="card rounded-lg pt-3 pb-3 bg-light  text-center"
                    style="text-center"
                > -->
                        <div style="text-align: -webkit-center" class=" pl-0">
                            <profile-image :user-name="'M'" size="large" />
                        </div>

                        <!-- </a> -->
                        <div class="notification-text">
                            teacher has created daily assignment has created
                            daily assignmenthas created daily assignment
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
.notification {
    display: flex;
    align-items: center;
}
.notification-text {
    text-align: left;
    padding: 0px 10px;
}
.card {
    padding: 10px 5px;
    margin: auto;
}
.time-gap {
    position: absolute;
    top: 10px;
    right: 0px;
}
.row {
    display: flex;
}
.classmates-section {
    margin: auto;
}
</style>
<script></script>
