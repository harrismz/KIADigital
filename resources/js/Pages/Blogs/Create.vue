<template>

    <div>
        <div class="card border-0 rounded shadow">
            <div class="card-body">
                <h4>TAMBAH BLOG</h4>
                <hr>
                <form @submit.prevent="storeBlog">
                    <div class="mb-3">
                        <label class="form-label">TITLE BLOG</label>
                        <input type="text" class="form-control" v-model="blog.title" placeholder="Masukkan Title Blog">
                        <div v-if="errors.title" class="mt-2 alert alert-danger">
                            {{ errors.title }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">CONTENT</label>
                        <textarea class="form-control" rows="5" v-model="blog.content"
                            placeholder="Masukkan Content Blog"></textarea>
                        <div v-if="errors.content" class="mt-2 alert alert-danger">
                            {{ errors.content }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary btn-md shadow-sm me-2">SIMPAN</button>
                        <button type="reset" class="btn btn-warning btn-md shadow-sm">RESET</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</template>

<script>
//import layout
import LayoutApp from '../../Layouts/App.vue'

import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'

export default {

    //layout
    layout: LayoutApp,

    //props
    props: {
        errors: Object
    },

    //define Composition Api
    setup() {

        //state blogs
        const blog = reactive({
            title: '',
            content: ''
        })

        //function storeblog
        function storeBlog() {

            //define variable
            let title = blog.title
            let content = blog.content

            //send data
            Inertia.post('/blogs/', {
                title: title,
                content: content
            })

        }

        return {
            blog,
            storeBlog
        }

    }
}
</script>
