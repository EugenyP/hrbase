<script setup>
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import NavLink from '@/components/NavLink.vue';
import { Head } from '@inertiajs/vue3';
import PersonList from "@/components/PersonList.vue";

defineProps({
	persons: {
		type: Array,
	}
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Бенч
            </h2>
        </template>

		<div class="py-12">
			<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
				<h2 class="text-l font-semibold mb-5">Последние кандидаты</h2>
				<PersonList :persons="persons"></PersonList>
			</div>
		</div>

    </AuthenticatedLayout>
</template>
