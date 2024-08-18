<template>
    <div class="p-8 bg-gray-100 font-sans flex flex-col items-center">
        <div class="flex items-center mb-8 w-full">
            <!-- <img src="@/assets/logo.png" alt="Logo" class="w-16 h-16 mr-4"> -->
        </div>

        <div v-if="mom" class="bg-white p-8 rounded-lg shadow-md text-center w-full md:w-2/3 lg:w-1/2">
            <h1 class="text-xl font-bold mb-4">{{ qrContent }}</h1>
            <canvas ref="qrcodeCanvas" class="mx-auto"></canvas>
            <p>Scan QR / Informasikan ID Pada Dokter untuk Menampilkan Dairy Ibu serta Catatan Kesehatan Ibu Terakhir
            </p>

            <router-link to="/" class="text-blue-500">Kembali</router-link>
        </div>
        
        <div v-else class="bg-white p-8 rounded-lg shadow-md text-center w-full md:w-2/3 lg:w-1/2">
            <h1 class="text-xl font-bold mb-4">Anda tidak Login Sebagai Ibu</h1>
            <!-- <canvas ref="qrcodeCanvas" class="mx-auto"></canvas> -->
            <div class="p-4 mb-2 mt-2">
                <img :src="baseUrl + '/storage/images/error.png'" alt="" class="mx-auto">
            </div>
            <p>LOGIN SEBAGAI IBU UNTUK MELIHAT QRCODE
            </p>

            <router-link to="/" class="text-blue-500">Kembali</router-link>
        </div>
        
    </div>
</template>

<script>
import QRCode from 'qrcode';
import {mapGetters} from 'vuex';

export default {
    name: "QRCode",
    data() {
        return {
            // userId: 'XXXXXXXXXXXXXXXXXXXXXXXX',
        };
    },
    mounted() {
        this.generateQRCode();
    },

    computed: {
        userId(){
            return this.$route.params.id;
        },

        qrContent(){
            let activeProfile = this.activeProfile;
            let guid = activeProfile.guid;
            if(!activeProfile){
                guid = this.mom.guid;
            }
            return this.baseUrl + '/checkup/show?id='+guid;
        },

        ...mapGetters(['baseUrl', 'mom', 'activeProfile'])
    },

    methods: {
        generateQRCode() {
            
            const canvasEl = this.$refs.qrcodeCanvas;
            
            if (canvasEl && canvasEl.getContext) {
                // const qrCodeData = `ID: ${this.userId}`;
                const qrCodeData = this.qrContent;
                QRCode.toCanvas(canvasEl, qrCodeData, { errorCorrectionLevel: 'H' }, (error) => {
                    if (error) console.error(error);
                    console.log('QR code generated!');
                });
            } else {
                console.error('Canvas element is not available.');
            }
        }
        // generateQRCode() {
        //     const canvasEl = this.$refs.qrcodeCanvas;
        //     if (canvasEl && canvasEl.getContext) {
        //         const qrCodeData = `ID: ${this.userId}`;
        //         QRCode.toCanvas(canvasEl, qrCodeData, { errorCorrectionLevel: 'H' }, (error) => {
        //             if (error) console.error(error);
        //             console.log('QR code generated!');
        //         });
        //     } else {
        //         console.error('Canvas element is not available.');
        //     }
        // }
        // generateQRCode() {
        //     const canvas = this.$refs.qrcodeCanvas;
        //     const url = `https://yourwebsite.com/user/${this.userId}`;

        //     QRCode.toCanvas(canvas, url, { errorCorrectionLevel: 'H' }, { width: 200 }, (error) => {
        //         if (error) console.error(error);
        //         console.log('QR code generated!');
        //     });
        // }
    }
};
</script>

<style scoped>
/* Jika Anda memiliki styling khusus, tambahkan di sini */
</style>
