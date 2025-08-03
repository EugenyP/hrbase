<template>
	<Head title="Список" />

	<AuthenticatedLayout>
		<template #header>
			<div class="flex justify-between">
				<h1
					class="text-xl font-semibold leading-tight text-gray-800"
				>Список кандидатов</h1>

				<Link title="" class="inline-flex gap-1 place-items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" :href="route('person.create')">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="block"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
					Добавить кандидата
				</Link>
			</div>
		</template>

		<div class="py-12">
			<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
				<Breadcrumbs class="mb-3" :breadcrumbs="breadcrumbs"/>

				<div class="bg-white my-4 p-2" v-if="categories.length">
					<h3 class="text-m">Категории</h3>
					<div class="category-tags">
						<NavLink class="tag" :href="route('person.index')" :class="{active: category == 0}">Все</NavLink>
						<NavLink class="tag" :class="{active: category == curCategory.id}" v-for="(curCategory, index) in categories" :href="route('person.index', { 'category': curCategory.id})">
							{{ curCategory.name }}
						</NavLink>
					</div>
				</div>

				<div class="bg-white my-4 p-2" v-if="availTags.length">
					<h3 class="text-m">Доступные технологии</h3>
					<div class="filter-tags">
						<span class="tag" v-for="(tag, index) in availTags" @click="addFilter(tag)">
							{{ tag.name.ru }}
						</span>
					</div>
				</div>

				<div class="bg-white my-4 p-2" v-if="filter.length">
					<h3 class="text-m">Выбранные технологии</h3>
					<div class="tags">
						<span class="tag" v-for="(tag, index) in filter">
							{{ tag.name.ru }} <span class="tag-remove" @click="removeFilter(index)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></span>
						</span>
					</div>
				</div>
				<PersonList :exp="exp" :persons="persons" :paginate="paginate"></PersonList>
			</div>
		</div>

	</AuthenticatedLayout>
</template>
<script>
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import NavLink from '@/components/NavLink.vue';
import { Head, router, Link  } from '@inertiajs/vue3';
import PersonList from "@/components/PersonList.vue";
import Breadcrumbs from "@/components/Breadcrumbs.vue";
import Checkbox from "@/components/ui/checkbox/Checkbox.vue";

export default{
	components: {Checkbox, Link, AuthenticatedLayout, NavLink, Head, PersonList,Breadcrumbs},
	data() {
		return {
			curFilter: this.filter
		}
	},
	props: {
		persons: {
			type: Array,
		},
		exp: {
			type: Boolean,
			required: false,
			default: false
		},
		categories: {
			type: Array,
			required: false,
			default: []
		},
		paginate: {
			type: String
		},
		filter: {
			type: Array,
			required: false,
			default: []
		},
		filterTags: {
			type: Array,
			required: false,
			default: []
		},
		category: {
			type: Number,
			required: false,
			default: 0
		},
		breadcrumbs: {
			type: Array,
			required: false,
			default: []
		},
	},
	methods: {
		addFilter(tag) {
			this.filter.splice(this.filter.length, 0, tag);
		},
		removeFilter(index) {
			this.filter.splice(index, 1);
		}
	},
	computed: {
		availTags() {
			return this.filterTags.filter(item1 =>
				!this.filter.some(item2 => item2.id === item1.id)
			);
		}
	},
	watch: {
		filter: {
			handler(newValue, oldValue) {
				let aTech = [];
				newValue.map((item) => {
					aTech.push(item.id);
				});
				let data = {
					tech: aTech
				};
				if (this.category) {
					data.category = this.category
				}
				router.visit(route('person.index'), {
					method: 'get',
					data: data
				});
			},
			deep: true
		}
	}
}

</script>
<style scoped>
.tags {
	cursor: default;
	display: flex;
	flex-wrap: wrap;
	gap: 5px;
	margin: 8px 0;
}

.filter-tags, .category-tags {
	cursor: default;
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
	margin: 5px 0 8px;
}
.filter-tags .tag {
	background: #fafafa;
	cursor: pointer;
	padding: 4px 10px;
	border-radius: 4px;
}
.filter-tags .tag:hover {
	background: #fefefe;
}
.category-tags .tag {
	background-color: #fff;
	padding: 4px 10px;
	border: 1px solid rgba(29, 78, 216, 1);
	border-radius: 4px;
	color: #333;
}
.category-tags .tag:hover {
	background-color: rgba(29, 78, 216, 0.95);
	border: 1px solid rgba(29, 78, 216, 1);
	color: #fff;
}
.tag {
	display: inline-flex;
	-webkit-align-items: center;
	-webkit-box-align: center;
	-ms-flex-align: center;
	align-items: center;
	height: 24px;
	gap: 5px;
	line-height: 22px;
	background-color: #f6f6f6;
	border: 1px solid #d0e0e0;
	border-radius: 2px;
	box-sizing: content-box;
	padding: 0 4px 0 10px;
	outline: 0;
	overflow: hidden;
}
.tag.active {
	background-color: rgba(29, 78, 216, 1);
	color: #fff;
	border: 1px solid rgba(29, 78, 216, 1);
}

.tag-remove {
	padding: 3px;
	cursor: pointer;
	cursor: pointer;
}
.tag-remove svg {
	display: block;
}
.tag-remove:hover svg path {
	stroke: #d00;
}
</style>
