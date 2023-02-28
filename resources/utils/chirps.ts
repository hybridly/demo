import { useAutoAnimate } from '@formkit/auto-animate/vue'

export function useInfiniteChirpLoading(initialChirps: Paginator<App.Data.ChirpData>) {
	const [list, enableChirpAnimations] = useAutoAnimate()
	const canLoad = computed(() => !!initialChirps.meta?.next_page_url)
	const chirps = ref<App.Data.ChirpData[]>([...initialChirps.data])

	function loadMoreChirps() {
		if (!canLoad.value) {
			return
		}

		router.get(initialChirps.meta!.next_page_url!, {
			preserveState: true,
			preserveScroll: true,
			preserveUrl: true,
			only: ['chirps'],
			hooks: {
				before: () => enableChirpAnimations(false),
				success: () => chirps.value.push(...initialChirps.data),
				after: () => enableChirpAnimations(true),
			},
		})
	}

	useInfiniteScroll(window, loadMoreChirps, {
		offset: { bottom: 300 },
	})

	return {
		list,
		enableChirpAnimations,
		canLoad,
		chirps,
		loadMoreChirps,
	}
}
