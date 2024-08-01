<template>
    <div class="p-8 bg-gray-100 font-sans">
        <div class="flex items-center mb-8">
            <img src="/storage/app/public/users/default.png" alt="Logo" class="w-16 h-16 mr-4">
            <div>
                <div class="text-lg font-bold">Diah Ayu Puspitasari</div>
                <div class="text-sm">HPL : DD MM YYYY</div>
            </div>
        </div>
        <Stepper :steps="weeks" :currentStep.sync="currentWeek" />
        <div class="flex justify-between mb-4 nav nav-tabs">
            <div class="flex-1 text-center py-2 bg-gray-200 rounded mx-1 nav-item">Trimester 1</div>
            <div class="flex-1 text-center py-2 bg-gray-200 rounded mx-1 nav-item">Trimester 2</div>
            <div class="flex-1 text-center py-2 bg-gray-200 rounded mx-1 nav-item">Trimester 3</div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <ProfileCard v-for="card in cards" :key="card.title" :title="card.title" :description="card.description"
                :link="card.link" :img="card.img" />
        </div>
    </div>
</template>

<script>
import Stepper from '../utils/Stepper.vue';
import ProfileCard from '../utils/ProfileCard.vue';
// import { useStore } from 'vuex';

// const store = useStore();

export default {
    components: {
        Stepper,
        ProfileCard
    },
    data() {
        return {
            user: {},
            mother: [],
            currentWeek: 0,
            weeks: [],
            cards: [
                { title: 'Info Janin Secara Umum', description: 'Tinggi : xxx cm Berat : xxx cm Ukuran : xxx Ciri-ciri : xxx', link: '#', img: '/storage/images/janin.png' },
                { title: 'Diary Ibu', description: 'Pemantauan mingguan, perawatan sehari-hari, serta keluhan yang dirasakan ibu dapat diisi secara mandiri dalam menu ini.', link: '#', img: '/storage/images/diary.png' },
                { title: 'Catatan Kesehatan Ibu', description: 'Hasil skrining preeklampsia dan hasil pemeriksaan kesehatan ibu, serta saran hingga tanggapan tenaga kesehatan terkait keluhan dapat dilihat dalam menu ini.', link: '#', img: '/storage/images/catatan.png' },
                { title: 'Grafik Evaluasi Kehamilan', description: 'Grafik peningkatan berat badan dan grafik evaluasi kehamilan dapat dipantau dalam menu ini.', link: '#', img: '/storage/images/grafik.png' },
                { title: 'Information', description: 'Informasi seputar kehamilan, pola makan dan minum ibu, aktivitas fisik dan latihan fisik, serta informasi relevan lainnya dapat dibaca pada menu ini.', link: '#', img: '/storage/images/informasi.png' },
                { title: 'Riwayat Persalinan', description: 'Informasi seputar persalinan, kondisi bayi saat lahir, hingga asuhan bayi baru lahir (IMD dalam 1 jam pertama kelahiran) bisa dapat dilihat dalam menu ini.', link: '#', img: '/storage/images/riwayat.png' },
            ]
        };
    },
    methods: {
        fetchUserAuth() {
            axios.get('/user/')
                .then(response => response.data)
                .then(response => {
                    this.user = response.user;
                    console.log('fetching user : ', response.user);
                })
                .catch(error => {
                    console.error(error);
                    toastr.error(`fetching user ERROR : ${error}`)
                });
        },
        fetchMother() {
            const user_id = this.user.id;
            axios.get(`/api/get_mother/${user_id}`)
                .then(response => response.data)
                .then(response => {
                    console.log('fetching mother : ', response.data);
                })
        },
        fetchWeekUser() {
            const mother_id = this.mother.id
            axios.get(`/api/get_week_user/${mother_id}`)
                .then(response => response.data)
                .then(response => {

                    console.log('fetching week : ', response);
                })
                .catch(error => {
                    console.error(error);
                    toastr.error(`fetching week ERROR : ${error}`)
                });

        }
    },
    mounted() {
        this.fetchUserAuth()
            .then(() => this.fetchMother(this.user))
            .then(() => this.fetchWeekUser(this.mother.id))
            .catch(error => console.error('Error fetching data:', error));
    // this.fetchWeekUser();
    // this.fetchMother();
    }
};
</script>
