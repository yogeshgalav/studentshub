<form @submit.prevent="exploreSearch">
    <div id="custom-search-input">
            <div class="input-group col-md-12">
                <input type="text" class="search-query form-control" name="explore_search" v-model="explore_search" placeholder="What do you want to learn ?" />
                <span class="input-group-btn">
                    <button class="btn btn-link" type="submit">
                        <i class=" fa fa-search text-black weight-400"></i>
                    </button>
                </span>
            </div>
        </div>
</form>