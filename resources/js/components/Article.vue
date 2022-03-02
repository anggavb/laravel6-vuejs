<template>
    <div>
        <div class="container mt-4">
            <h1 class="text-center">
                Laravel 6 + VueJS
            </h1>
            <hr>

            <div class="card card-body mb-4">
                <form @submit.prevent="createArticle">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control" v-model="article.title">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="body">Body</label>
                                <textarea name="body" id="body" class="form-control" v-model="article.body"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-flat">Submit</button>
                        </div>
                    </div>
                </form>
            </div>

            <nav class="mt-4">
                <ul class="pagination">
                    <li class="page-item" v-bind:class="[{ disabled: !pagination.prev_page_url }]">
                        <a class="page-link" href="#" @click="fetchArticles(pagination.prev_page_url)">Previous</a>
                    </li>
                    <li class="page-item" >
                        <a class="page-link disabled text-dark" href="#">{{ pagination.current_page }} of {{ pagination.last_page }}</a>
                    </li>
                    <li class="page-item" v-bind:class="[{ disabled: !pagination.next_page_url }]">
                        <a class="page-link" href="#" @click="fetchArticles(pagination.next_page_url)">Next</a>
                    </li>
                </ul>
            </nav>

            <div class="card mb-4" v-for="(article, index) in articles" v-bind:key="index">
                <div class="card-header bg-info text-white">
                    <div class="card-title">
                        <h4>
                            {{ article.title }}
                        </h4>
                    </div>
                </div>
                
                <div class="card-body">
                    <p>
                        {{ article.body }}
                    </p>
                </div>
                
                <div class="card-footer">
                    <button class="btn btn-warning" @click="editArticle(article)">Edit</button>
                    <button class="btn btn-danger" @click="deleteArticle(article.id)">Delete</button>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            article: {
                id: null,
                title: null,
                body: null,
                article_id: null,
            },
            edit: false,
            pagination: {}
        }
    },

    created() {
        this.fetchArticles();
    },

    methods: {
        // Fetch articles
        fetchArticles(page_url) {
            let vm = this
            page_url = page_url || 'api/articles'
            fetch(page_url)
                .then(articles => articles.json())
                .then(articles => {
                    this.articles = articles.data
                    vm.makePagination(articles.meta, articles.links)
                }).catch(error => console.log(error))
        },

        // Paginate Article
        makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
            };
            this.pagination = pagination;
        },

        // Create Article
        createArticle() {
                fetch('api/article', {
                    method: 'POST',
                    body: JSON.stringify(this.article),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(article => article.json())
                    .then(article => {
                        this.article.title = null
                        this.article.body = null
                        this.fetchArticles()
                        alert('Article Berhasil Dibuat')
                    }).catch(error => console.log(error))
        },

        // Edit Article Form
        editArticle(article) {
            this.article = article;
            this.edit = true;
        },

        updateArticle() {
            fetch('api/article', {
                    method: 'PUT',
                    body: JSON.stringify(this.article),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(article => article.json())
                    .then(article => {
                        this.article.title = null
                        this.article.body = null
                        this.article.article_id = null
                        this.article.id = null
                        this.edit = false
                        alert('Article Berhasil Dibuat')
                        this.fetchArticles()
                    }).catch(error => console.log(error))
        },

        // Delete Article
        deleteArticle(id) {
            if(confirm('Are you sure want to delete this article?')) {
                fetch(`api/article/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(article => article.json())
                    .then(article => {
                        this.article.title = null
                        this.article.body = null
                        this.fetchArticles()
                        alert('Article Berhasil Dihapus')
                    }).catch(error => console.log(error))
            }
        }
    }
}
</script>