<template>
    <NuxtLayout name="auth-layout">

        <Head>
            <Title>Sukurti prizą</Title>
        </Head>

        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Sukurti prizus
                </h2>
            </div>
        </template>

        <div class="container mx-auto mt-10">
            <el-card>
                <form @submit.prevent="submitForm">
                    <!-- prize name -->
                    <div class="mt-4">
                        <Label for="prize_name">Pavadinimas</Label>
                        <Input id="prize_name" class="block mt-1 w-full" v-model="data.name" :errors="errors.name" />
                    </div>

                    <!-- prize description -->
                    <div class="mt-4">
                        <Label for="prize_description">Aprašymas</Label>
                        <Textarea id="prize_description" class="block mt-1 w-full" v-model="data.description"
                            :errors="errors.description" />
                    </div>

                    <!-- prize price-->
                    <div class="mt-4">
                        <Label for="prize_price">Kaina</Label>
                        <Input id="prize_price" class="block mt-1 w-full" v-model="data.price" :errors="errors.price" />
                    </div>

                    <!-- button to add prize code -->
                <div class="mt-4">
                        <Label for="prize_code">Kodas</Label>
                        <Input id="prize_code" class="block mt-1 w-full" v-model="prizeCode" :errors="errors.prize_code" />
                        <!-- input type button -->
                        <input type="button" class="mt-4" value="Pridėti" @click="addPrizeCode" />

                    </div>

                    <!-- prize codes -->
                    <div class="mt-4">
                        <Label for="prize_codes">Kodai</Label>
                        <div class="flex flex-col">
                            <div v-for="(prizeCode, index) in data.prize_codes" :key="index">
                                <div class="flex flex-row justify-between">
                                    <span>{{ prizeCode }}</span>
                                    <!--input -->
                                    <input type="button" class="mt-4" value="Ištrinti" @click="deletePrizeCode(index)" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <NuxtLink href="/litter/list" class="underline text-sm text-gray-600 hover:text-gray-900">
                            Atšaukti
                        </NuxtLink>

                        <Button type="primary" class="ml-3">Sukurti</Button>
                    </div>
                </form>
                
            </el-card>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200"></div>
            </div>
        </div>
    </NuxtLayout>
</template>

<script setup lang="ts">

import { serialize } from "object-to-formdata";
import { ServerSideResponse } from "~/types/generalTypes";

const errors = ref<Record<string, string>>({});
const errorMessage = ref<string>("");
const successMessage = ref<string>("");

async function submitForm() {
    errors.value = {};
    errorMessage.value = "";
    successMessage.value = "";



    const response: ServerSideResponse = await $fetch(`/api/prize/`, {
        method: "POST",
        body: data.value,
    });

    if (response.status) {
        successMessage.value = "Prize created successfully";

        return await navigateTo("/prize/list");
    }

    if (response.data.errors) {
        errors.value = response.data.errors;

        return;
    }

    errorMessage.value = response.data.data;
}

const prizeCodes = ref([]);
const prizeCode = ref("");
const prizeCodeIsRedeemed = ref(false);

const data = ref({
    name: "",
    description: "",
    price: 0,
    prize_codes: [],
});

//addPrizeCode
function addPrizeCode() {
    if (prizeCode.value.length < 1) {
        return;
    }

    const prizeCodeObject = {
        code: prizeCode.value,
        is_redeemed: prizeCodeIsRedeemed.value,
    };

    prizeCodes.value.push(prizeCodeObject);

    data.value.prize_codes = prizeCodes.value;

    prizeCode.value = "";
    prizeCodeIsRedeemed.value = false;
}

//removePrizeCode
function removePrizeCode(index) {
    prizeCodes.value.splice(index, 1);

    data.value.prize_codes = prizeCodes.value;
}
</script>
