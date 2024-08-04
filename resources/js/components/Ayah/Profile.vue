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
        <div class="flex justify-between mb-4">
            <div class="flex-1 text-center py-2 bg-gray-200 rounded mx-1">Trimester 1</div>
            <div class="flex-1 text-center py-2 bg-gray-200 rounded mx-1">Trimester 2</div>
            <div class="flex-1 text-center py-2 bg-gray-200 rounded mx-1">Trimester 3</div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <ProfileCard v-for="card in cards" :key="card.title" :title="card.title" :description="card.description"
                :link="card.link" />
        </div>
    </div>
</template>

<script>
import Stepper from '../utils/Stepper.vue';
import ProfileCard from '../utils/ProfileCard.vue';
import { useStore } from 'vuex';

const store = useStore();

export default {
    components: {
        Stepper,
        ProfileCard
    },
    data() {
        return {
            currentWeek: 0,
            weeks: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
            cards: [
                { title: 'Info Janin Secara Umum', description: 'Tinggi : xxx cm Berat : xxx cm Ukuran : xxx Ciri-ciri : xxx', link: '#' },
                { title: 'Diary Ibu', description: 'Pemantauan mingguan, perawatan sehari-hari, serta keluhan yang dirasakan ibu dapat diisi secara mandiri dalam menu ini.', link: '#' },
                { title: 'Catatan Kesehatan Ibu', description: 'Hasil skrining preeklampsia dan hasil pemeriksaan kesehatan ibu, serta saran hingga tanggapan tenaga kesehatan terkait keluhan dapat dilihat dalam menu ini.', link: '#' },
                { title: 'Grafik Evaluasi Kehamilan', description: 'Grafik peningkatan berat badan dan grafik evaluasi kehamilan dapat dipantau dalam menu ini.', link: 'pregnancy_history' },
                { title: 'Information', description: 'Informasi seputar kehamilan, pola makan dan minum ibu, aktivitas fisik dan latihan fisik, serta informasi relevan lainnya dapat dibaca pada menu ini.', link: '#' },
                { title: 'Riwayat Persalinan', description: 'Informasi seputar persalinan, kondisi bayi saat lahir, hingga asuhan bayi baru lahir (IMD dalam 1 jam pertama kelahiran) bisa dapat dilihat dalam menu ini.', link: '#' },
            ]
        };
    }
};
</script>
