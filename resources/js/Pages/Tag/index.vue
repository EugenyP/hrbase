<script setup>
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import NavLink from '@/components/NavLink.vue';
import {Head, useForm} from '@inertiajs/vue3';
import Icon from "@/components/Icon.vue";
import PrimaryButton from "@/components/PrimaryButton.vue";
import PersonList from "@/components/PersonList.vue";
import Breadcrumbs from "@/components/Breadcrumbs.vue";

const confirma = function(text) {
	return confirm(text);
}

defineProps({
	tags: {
		type: Array,
		required: false,
		default: []
	},
	paginate: {
		type: String
	},
	breadcrumbs: {
		type: Array,
		required: false,
		default: []
	},
});
const form = useForm();
</script>

<template>
	<Head title="Список технологий" />

	<AuthenticatedLayout>
		<template #header>
			<div class="flex justify-between">
				<h1
					class="text-xl font-semibold leading-tight text-gray-800"
				>Список технологий</h1>
			</div>
		</template>

		<div class="py-12">
			<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
				<Breadcrumbs class="mb-3" :breadcrumbs="breadcrumbs"/>
				<div class="text-gray-900 bg-slate-50">
					<table v-if="tags.length" class="border-collapse table-auto w-full text-sm">
						<thead>
						<tr>
							<th width="40" class="border-b dark:border-slate-600 font-medium p-4 pb-3 text-slate-400 dark:text-slate-200 text-left">ID</th>
							<th class="border-b dark:border-slate-600 font-medium p-4 pb-3 text-slate-400 dark:text-slate-200 text-left">Название</th>
							<th class="border-b dark:border-slate-600 font-medium p-4 pb-3 text-slate-400 dark:text-slate-200 text-left"></th>
						</tr>
						</thead>
						<tbody class="bg-white">
						<tr v-for="tag in tags">
							<td class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">{{ tag.id }}</td>
							<td class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">{{ tag.name.ru }}</td>
							<td width="120" class="border-b border-slate-100 dark:border-slate-700 p-4">
								<div class="flex gap-1 items-center">
									<form @submit.prevent="confirma('Удалить') && form.delete(route('tags.delete', tag.id))" method="POST">
										<button type="submit" class="block text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:ring-orange-300 font-medium rounded-lg text-sm px-2 py-1 dark:bg-orange-600 dark:hover:bg-orange-700 focus:outline-none dark:focus:ring-orange-800">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
										</button>
									</form>
								</div>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
				<div v-if="paginate" class="mt-8" v-html="paginate"></div>
			</div>
		</div>

	</AuthenticatedLayout>
</template>
