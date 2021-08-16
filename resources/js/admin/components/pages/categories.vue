<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Category <Button @click="addModal=true" class="ml-3"><Icon type="md-add" /> Add Category</Button></p>
                    <div class="_overflow _table_div">
                        <table class="_table">
                            <tr>
                                <th>ID</th>
                                <th>Category name</th>
                                <th>Icon</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            <tr v-for="(category, i) in categories" :key="i" v-if="categories.length">
                                <td>{{category.id}}</td>
                                <td class="_table_name">{{category.categoryName}}</td>
                                <td class="table_image">
                                    <img :src="category.iconImage" height="100px"  />
                                </td>
                                <td>{{category.created_at}}</td>
                                <td>
                                    <Button type="info" size="small" @click="showEditModal(category, i)">Edit</Button>
                                    <Button type="error" size="small" @click="showDeleteModal(category, i)" :loading="category.isDeleting">Delete</Button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <Modal
                        v-model="addModal"
                        title="Add Category"
                        :mask-closable="false"
                        :closable="false">
                        <Input v-model="data.categoryName" placeholder="Add category name" />
                        <div class="pt-3">
                            <Upload
                                ref="uploads"
                                type="drag"
                                :headers="{'x-csrf-token': token, 'X-Requested-With': 'XMLHttpRequest'}"
                                :on-success="handleSuccess"
                                :on-error="handleError"
                                :on-format-error="handleFormatError"
                                :on-exceeded-size="handleMaxSize"
                                :format="['jpg','jpeg','png']"
                                :max-size="2048"
                                action="api/app/upload_icon">
                                <div style="padding: 20px 0">
                                    <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                    <p>Click or drag files here to upload</p>
                                </div>
                            </Upload>
                        </div>
                        <div class="demo-upload-list" v-if="data.iconImage">
                            <img :src="`${data.iconImage}`">
                            <div class="demo-upload-list-cover">
                                <Icon type="ios-trash-outline" @click="deleteIcon"></Icon>
                            </div>
                        </div>
                        <div slot="footer">
                            <Button type="default" @click="addModal=false">Close</Button>
                            <Button type="primary" @click="addCategory" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding..' : 'Add Category'}}</Button>
                        </div>
                    </Modal>
                    <Modal
                        v-model="editModal"
                        title="Edit Category"
                        :mask-closable="false"
                        :closable="false">
                        <Input v-model="editData.categoryName" placeholder="Add category name" />
                        <div class="pt-3">
                            <Upload v-show="isNewIcon"
                                ref="editing"
                                type="drag"
                                :headers="{'x-csrf-token': token, 'X-Requested-With': 'XMLHttpRequest'}"
                                :on-success="handleSuccess"
                                :on-error="handleError"
                                :on-format-error="handleFormatError"
                                :on-exceeded-size="handleMaxSize"
                                :format="['jpg','jpeg','png']"
                                :max-size="2048"
                                action="api/app/upload_icon">
                                <div style="padding: 20px 0">
                                    <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                    <p>Click or drag files here to upload</p>
                                </div>
                            </Upload>
                        </div>
                        <div class="demo-upload-list" v-if="editData.iconImage">
                            <img :src="`${editData.iconImage}`">
                            <div class="demo-upload-list-cover">
                                <Icon type="ios-trash-outline" @click="deleteIcon(false)"></Icon>
                            </div>
                        </div>
                        <div slot="footer">
                            <Button type="default" @click="closeEditModal">Close</Button>
                            <Button type="primary" @click="editCategory" :disabled="isEditing" :loading="isEditing">{{isEditing ? 'Editing..' : 'Edit Category'}}</Button>
                        </div>
                    </Modal>
<!--                    <Modal-->
<!--                        v-model="deleteModal"-->
<!--                        width="360">-->
<!--                        <p slot="header" style="color:#f60;text-align:center">-->
<!--                            <Icon type="ios-information-circle"></Icon>-->
<!--                            <span>Delete confirmation</span>-->
<!--                        </p>-->
<!--                        <div style="text-align:center">-->
<!--                            <p>Are u sure u want to delete this tag?</p>-->
<!--                        </div>-->
<!--                        <div slot="footer">-->
<!--                            <Button type="error" size="large" long @click="deleteCategory" :disabled="isDeleting" :loading="isDeleting">-->
<!--                                {{ isDeleting ? 'Deleting...' : 'Delete Category' }}</Button>-->
<!--                        </div>-->
<!--                    </Modal>-->
                        <delete-modal></delete-modal>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import deleteModal from "../deleteModal";
import { mapGetters } from "vuex";
export default {
    name: "categories",
    data(){
        return{
            data : {
                categoryName: '',
                iconImage: ''
            },
            editData: {
                categoryName: '',
                iconImage: ''
            },
            addModal: false,
            editModal: false,
            deleteModal: false,
            isAdding: false,
            isEditing: false,
            isDeleting: false,
            isNewIcon: false,
            categories: [],
            index: -1,
            deleteItem: {},
            deletingIndex: -1,
            token: ''
        }
    },
    methods: {
        async addCategory(){
            if (this.data.categoryName.trim()==='') return this.error('Category name is required')
            if (this.data.iconImage.trim()==='') return this.error('Icon name is required')
            this.isAdding = true
            this.data.iconImage = `${this.data.iconImage}`
            const res = await this.callApi('post', 'api/app/create_category', this.data);
            if (res.status === 201){
                this.categories.unshift(res.data)
                this.success('Category has been added successfully!')
                this.data.categoryName = ''
                this.data.iconImage = ''
            } else {
                if (res.status === 422){
                    if(res.data.errors.categoryName){
                        this.info(res.data.errors.categoryName[0])
                    }
                    if(res.data.errors.iconImage){
                        this.info(res.data.errors.iconImage[0])
                    }
                } else {
                    this.swr()
                }
            }
            this.$refs.uploads.clearFiles()
            this.isAdding = false
            this.addModal = false
        },
        async editCategory(){
            if (this.editData.categoryName.trim()==='') return this.error('Category name is required')
            if (this.editData.iconImage.trim()==='') return this.error('Icon name is required')
            this.isEditing = true
            const res = await this.callApi('post', 'api/app/edit_category', this.editData);
            if (res.status === 200){
                this.categories[this.index].categoryName = this.editData.categoryName
                this.success('Category has been edited successfully!')
            } else {
                if (res.status === 422){
                    if(res.data.errors.categoryName){
                        this.info(res.data.errors.categoryName[0])
                    }
                    if(res.data.errors.iconImage){
                        this.info(res.data.errors.iconImage[0])
                    }
                } else {
                    this.swr()
                }
            }
            this.isEditing = false
            this.editModal = false
        },
        // async deleteCategory(category, i){
        //     this.isDeleting = true
        //     const res = await this.callApi('post', 'api/app/delete_category', this.deleteItem);
        //     if(res.status === 200){
        //         this.categories.splice(this.deletingIndex, 1)
        //         this.success('Category has been deleted successfully!')
        //     } else {
        //         this.swr()
        //     }
        //     this.isDeleting = false
        //     this.deleteModal = false
        // },
        async deleteIcon (isAdd=true) {
            let icon
            if(!isAdd){
                this.isNewIcon = true
                icon = this.editData.iconImage
                this.editData.iconImage = ''
                this.$refs.editing.clearFiles()
            } else {
                icon = this.data.iconImage
                this.data.iconImage = ''
                this.$refs.uploads.clearFiles()
            }
            const res = await this.callApi('post', 'api/app/delete_icon', {iconName: icon})
            if(res.status !== 200){
                this.data.iconImage = icon
                this.swr()
            }
        },
        showEditModal(category, index){
            this.editData = category
            this.editModal = true
            this.index = index
        },
        showDeleteModal(category, index){
            const deleteModalObj = {
                showDeleteModal: true,
                deleteUrl: "api/app/delete_category",
                data: category,
                deletingIndex: index,
                isDeleting: false,
                successMsg: "Categoria eliminada",

            };
            this.$store.commit("setDeletingModalObj", deleteModalObj);
        },
        closeEditModal(){
            this.editModal = false
            this.isEditing = false
        },
        handleSuccess (res, file) {
            res = `/uploads/${res}`
            if(this.isNewIcon){
                return this.editData.iconImage = res
            }
            this.data.iconImage = res
        },
        handleError (res, file) {
            this.$Notice.error({
                title: 'The file format is incorrect',
                desc: `${file.errors.file.length ? file.errors.file[0] : 'Something went wrong'}`
            });
        },
        handleFormatError (file) {
            this.$Notice.warning({
                title: 'The file format is incorrect',
                desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
            });
        },
        handleMaxSize (file) {
            this.$Notice.warning({
                title: 'Exceeding file size limit',
                desc: 'File  ' + file.name + ' is too large, no more than 2M.'
            });
        },
    },
    async created(){
        this.token = window.Laravel.csrfToken
        const res = await this.callApi('get', 'api/app/get_category')
        if (res.status === 200){
            this.categories = res.data
        } else {
            this.swr()
        }
    },
    components: {
        deleteModal
    },
    computed: {
        ...mapGetters(["getDeleteModalObj"])
    },
    watch: {
        getDeleteModalObj(obj) {
            if (obj.isDeleted) {
                this.categories.splice(obj.deletingIndex, 1);
            }
        }
    }
}
</script>

<style scoped>
.demo-upload-list{
    display: inline-block;
    width: 60px;
    height: 60px;
    text-align: center;
    line-height: 60px;
    border: 1px solid transparent;
    border-radius: 4px;
    overflow: hidden;
    background: #fff;
    position: relative;
    box-shadow: 0 1px 1px rgba(0,0,0,.2);
    margin-right: 4px;
}
.demo-upload-list img{
    width: 100%;
    height: 100%;
}
.demo-upload-list-cover{
    display: none;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0,0,0,.6);
}
.demo-upload-list:hover .demo-upload-list-cover{
    display: block;
}
.demo-upload-list-cover i{
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    margin: 0 2px;
}
</style>
