<template>
    <div>
        <div class="col-md-12">
            <h1>My interests</h1>
        </div>
        <hr />
        <div class="classmates-section col-md-7 col-sm-12">
            <div class="classmate card">
                <div class="row">
                    <div class="text-center col-md-4">
                        <p class="font-size-60 weight-600 text-blue percentage">
                            14%
                        </p>
                    </div>
                    <div class="col-md-7 mt-2 mb-1">
                        <p class="font-size-24 weight-400">
                            engineering and technology
                        </p>
                        <p class="text-grey action-section">
                            <span>
                                <i
                                    class="fa fa-thumbs-up"
                                    aria-hidden="true"
                                />2 Like
                            </span>
                            <span> <i class="fas fa-eye" />22 Views </span>
                            <span> <i class="fas fa-share" />10 Share </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
.percentage {
    border-right: 1px solid black;
}
.card {
    padding: 20px 10px;
}
.row {
    display: flex;
    align-items: center;
    justify-content: space-evenly;
}
.action-section span {
    margin: 0px 5px;
}
.action-section svg {
    margin-right: 2px;
}
.classmates-section {
    margin: auto;
}
@media only screen and (max-width: 1200px) {
    .percentage {
        border-right: none !important;                   
    }
    p {
        text-align: center !important;
    }
}
</style>
<script></script>
