<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Admin User <Button @click="addModal=true"><Icon type="md-add" /> Add Admin</Button></p>
                    <div class="_overflow _table_div">
                        <table class="_table">
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>User Type</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            <tr v-for="(user, i) in users" :key="i" v-if="users.length">
                                <td>{{user.id}}</td>
                                <td class="_table_name">{{user.fullName}}</td>
                                <td>{{user.email}}</td>
                                <td>{{user.userType}}</td>
                                <td>{{user.created_at}}</td>
                                <td>
                                    <Button type="info" size="small" @click="showEditModal(user, i)">Edit</Button>
                                    <Button type="error" size="small" @click="showDeleteModal(user, i)" :loading="user.isDeleting">Delete</Button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <Modal
                        v-model="addModal"
                        title="Add Admin"
                        :mask-closable="false"
                        :closable="false">
                        <Input type="text" class="mb-3" v-model="data.fullName" placeholder="Full name" />
                        <Input type="email" class="mb-3" v-model="data.email" placeholder="Email" />
                        <Input type="password" class="mb-3" v-model="data.password" placeholder="Password" />
                        <Select v-model="data.userType" placeholder="Select admin type">
                            <Option value="Admin">Admin</Option>
                            <Option value="Editor">Editor</Option>
                        </Select>
                        <div slot="footer">
                            <Button type="default" @click="addModal=false">Close</Button>
                            <Button type="primary" @click="addAdmin" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding..' : 'Add Admin User'}}</Button>
                        </div>
                    </Modal>
                    <Modal
                        v-model="editModal"
                        title="Edit Admin User"
                        :mask-closable="false"
                        :closable="false">
                        <Input type="text" class="mb-3" v-model="editData.fullName" placeholder="Full name" />
                        <Input type="email" class="mb-3" v-model="editData.email" placeholder="Email" />
                        <Input type="password" class="mb-3" v-model="editData.password" placeholder="Password" />
                        <Select v-model="editData.userType" placeholder="Select admin type">
                            <Option value="Admin">Admin</Option>
                            <Option value="Editor">Editor</Option>
                        </Select>
                        <div slot="footer">
                            <Button type="default" @click="editModal=false">Close</Button>
                            <Button type="primary" @click="editAdmin" :disabled="isEditing" :loading="isEditing">{{isEditing ? 'Editing..' : 'Edit Admin User'}}</Button>
                        </div>
                    </Modal>
                    <deleteModal></deleteModal>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import deleteModal from '../deleteModal'
import { mapGetters } from 'vuex'
export default {
    name: "adminusers",
    components: {deleteModal},
    data(){
        return{
            data : {
                fullName: '',
                email: '',
                password: '',
                userType: '',
            },
            editData: {
                fullName: '',
                email: '',
                password: '',
                userType: '',
            },
            addModal: false,
            editModal: false,
            deleteModal: false,
            isAdding: false,
            isEditing: false,
            isDeleting: false,
            users: [],
            index: -1,
            deleteItem: {},
            deletingIndex: -1,
        }
    },
    methods: {
        async addAdmin(){
            if (this.data.fullName.trim() === '') return this.error('Full Name is required')
            if (this.data.email.trim() === '') return this.error('Email is required')
            if (this.data.password.trim() === '') return this.error('Password is required')
            if (this.data.userType.trim() === '') return this.error('User Type is required')
            const res = await this.callApi('post', 'api/app/create_user', this.data);
            this.isAdding = true
            if (res.status === 201){
                this.users.unshift(res.data)
                this.success('Admin User has been added successfully!')
                this.data.fullName = ''
            } else {
                if (res.status === 422){
                    for (let i in res.data.errors){
                        this.error(res.data.errors[i])
                    }
                } else {
                    this.swr()
                }
            }
            this.isAdding = false
            this.addModal = false
        },
        async editAdmin(){
            if (this.editData.fullName.trim() === '') return this.error('Full Name is required')
            if (this.editData.email.trim() === '') return this.error('Email is required')
            if (this.editData.userType.trim() === '') return this.error('User Type is required')
            const res = await this.callApi('post', 'api/app/edit_user', this.editData);
            this.isEditing = true
            if (res.status === 200){
                this.users[this.index].fullName = this.editData.fullName
                this.users[this.index].email = this.editData.email
                this.users[this.index].userType = this.editData.userType
                this.success('Admin user has been edited successfully!')
            } else {
                if (res.status === 422){
                    for (let i in res.data.errors){
                        this.error(res.data.errors[i])
                    }
                } else {
                    this.swr()
                }
            }
            this.isEditing = false
            this.editModal = false
        },
        async deleteAdmin(){
            this.isDeleting = true
            const res = await this.callApi('post', 'api/app/delete_user', this.deleteItem);
            if(res.status === 200){
                this.users.splice(this.deletingIndex, 1)
                this.success('Admin User has been deleted successfully!')
            } else {
                this.swr()
            }
            this.isDeleting = false
            this.deleteModal = false
        },
        showEditModal(user, index){
            let obj = {
                id: user.id,
                fullName: user.fullName,
                email: user.email,
                userType: user.userType
            }
            this.editData = obj
            this.editModal = true
            this.index = index
        },
        showDeleteModal(user, index){
            const deleteModalObj = {
                showDeleteModal: true,
                deleteUrl: 'api/app/delete_user',
                data: user,
                deletingIndex: index,
                isDeleting: false,
                successMsg: "Admin user deleted",
                msg: "¿Are u sure want delete this item?, esta acción no puede revertirse"
            }
            this.$store.commit('setDeletingModalObj', deleteModalObj)
        },
    },
    async created(){
        const res = await this.callApi('get', 'api/app/get_user')
        if (res.status === 200){
            this.users = res.data
            console.log(this.users)
        } else {
            this.swr()
        }
    },
    computed : {
        ...mapGetters(['getDeleteModalObj'])
    },
    watch : {
        getDeleteModalObj(obj){
            if(obj.isDeleted){
                this.users.splice(obj.deletingIndex,1)
            }
        }
    }
}
</script>

<style scoped>

</style>
