<template>
    <div class="container">
        <!-- textarea -->
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="form-floating">
                    <textarea v-model="massege" class="form-control" placeholder="Comments"
                              id="floatingTextarea2"
                              style="height: 100px">
                    </textarea>
                    <label for="floatingTextarea2">Comments</label>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <button class="btn btn-success m-2" @click="sendComment" :disabled="btnLoading.sentMsg">
                    <span class="m-2">send</span>
                    <i class="bi bi-send"></i>
                </button>
            </div>
        </div>
        <!-- textarea end -->

        <!-- sort -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light mt-4">
            <div class="container-fluid justify-content-lg-end">
                <div class="d-lg-flex">
                    <a class="navbar-brand" href="#">Sort by:</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarNav"
                            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link text-info" href="#" @click="sortByCommentDate(!sortReverse)">
                                    comment date
                                    <i v-show="!sortReverse" class="bi bi-arrow-down-short"></i>
                                    <i v-show="sortReverse" class="bi bi-arrow-up-short"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <!-- sort end-->

        <!-- comments list -->
        <div class="row d-flex justify-content-center">
            <div class="col-12 mt-2" v-for="comment in commentsData" :key="comment.id">
                <div class="card shadow-0 border" style="background-color: #f0f2f5;">
                    <div class="card-body p-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <p>{{ comment.text }}</p>
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex flex-row align-items-center">
                                        <img :src="comment.user.avatar"
                                             alt="avatar" width="25"
                                             height="25"/>
                                        <p class="small mb-0 ms-2">{{ comment.user.name }}</p>
                                    </div>
                                    <div class="d-flex flex-row align-items-center">
                                        <p class="small text-muted mb-0">{{ comment.created_at }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--show more -->
            <div class="col-12 mt-2 text-center" @click="pagination" v-show="btnMoreShow">
                <button type="button" :disabled="btnLoading.loadMore" class="btn btn-secondary">Load more</button>
            </div>
            <!--show more end -->
        </div>
        <!-- comments list end -->
    </div>
</template>

<script>
export default {
    name: "CommentsComponent",
    props: {
        'comments': {},
        'commentsCount': 0,
        'commentsPre': 0,
        'postId': null,
        'userId': null,
    },
    data: function () {
        return {
            massege: "",
            commentsCurrentList: 1,
            commentsData: [],
            sortReverse: false,
            btnMoreShow: true,
            btnLoading: {
                loadMore: false,
                sentMsg: false
            }
        }
    },
    mounted() {
        this.commentsData = this.comments;
        this.checkVisibleBtnMore();
    },
    methods: {
        sendComment: function () {
            //TODO Добавить валидацию форм.
            if (this.massege.length === 0) {
                alert('Text can not be empty');
                return false;
            }

            if (this.btnLoading.sentMsg) {
                return false;
            }

            this.btnLoading.sentMsg = true;
            axios.post("/comments/add", {
                "postId": this.postId,
                "comment": this.massege,
                "userId": this.userId
            }).then((response) => {
                this.commentsData.unshift(response.data);
                this.massege = '';
                this.btnLoading.sentMsg= false;
            }).then(() =>
                this.sortByCommentDate(false)
            );

        },
        pagination: function () {

            if (this.btnLoading.loadMore) {
                return false;
            }

            this.btnLoading.loadMore = true;

            axios.post("/comments/load-more-comments", {
                "commentsPre": this.commentsPre,
                "postId": this.postId,
                "commentsCurrentList": this.commentsCurrentList
            }).then((response) => {
                this.commentsCurrentList++
                this.commentsData.push(...response.data.comments);
            }).then(() => {
                document.querySelector('.container .card-body .btn-secondary').scrollIntoView();
                this.checkVisibleBtnMore();
                this.sortByCommentDate(false)
                this.btnLoading.loadMore = false;
            });
        },
        sortByCommentDate: function (rev) {
            this.commentsData.sort((a, b) => {
                if (rev) {
                    return new Date(a.created_at) - new Date(b.created_at);
                }
                return new Date(b.created_at) - new Date(a.created_at);
            });

            this.sortReverse = rev;
        },
        checkVisibleBtnMore: function () {
            if (this.commentsCount <= this.commentsData.length) {
                this.btnMoreShow = false;
            }
        },
    }
}
</script>

