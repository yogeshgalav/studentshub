<template>
    <main>
        <slot></slot>
        <button type="button" @click="sharePost">share</button>
        
        <div class="row main-habit-builder">
            <div class="col-md-6">
                <div class="card h-card" @click="viewPost">
                    <div class="card-header">

                        <div class="row">
                            <h3>Post Description</h3>
                            <p>post content</p>

                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <post-view-modal ref="postViewModal"></post-view-modal>
            <modal name="artical-modal">
            <vue-editor
                v-model="content"
                @focus="onEditorFocus"
                @blur="onEditorBlur"
                @selection-change="onSelectionChange"
            />
        </modal>
    </main>
</template>
<style scoped>

    .main-habit-builder {
        margin: auto;
    }

    .main-habit-builder .btn-default {
        background: #fff !important;
        box-shadow: 2px 2px 2px #bbbbcc;
        border: 1px solid #eee;
        font-size: 17px;
        font-family: Arial, Helvetica, sans-serif;
        color: #bbbbcc !important;
        font-weight: bold;
        margin-right: 20px;
        margin-bottom: 5px;
    }

    .main-habit-builder input {
        color: #bbbbcc;
    }

    .main-habit-builder .card {
        padding: 20px !important;
    }

    .main-habit-builder h2 {
        font-size: 36px;
        font-weight: 600;
        font-family: Arial, Helvetica, sans-serif;
        color: #000;
    }

    .main-habit-builder p {
        font-weight: bold;
        font-family: Arial, Helvetica, sans-serif;
        color: #000;
        margin: 2px 0px 2px 0px;
    }
</style>

<script>
import { VueEditor } from "vue2-editor";
import PostViewModal from './../post/post-view-modal'
    export default {
        name: 'HabitBuilderModal',
        components:{
            PostViewModal,VueEditor
        },
        data() {
            return {
                content:''
            }
        },
        methods: {
            trans: function (string, defaultString) {
                return this.$trans('home', string, defaultString);
            },
            viewPost(){
                this.$refs.postViewModal.openModal();
            },
            sharePost(){
                 this.$modal.show('artical-modal');
            }
        },
    }
</script>
