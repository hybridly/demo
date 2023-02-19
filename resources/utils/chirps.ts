import { useAutoAnimate } from '@formkit/auto-animate/vue'
import type { EventBusKey } from '@vueuse/core'
import axios from 'axios'

const likeBusKey: EventBusKey<{ id: string; liked: boolean }> = Symbol('like')
const likeBus = useEventBus(likeBusKey)

export function useChirpLikes(chirp: App.Data.ChirpData, authorization: App.Data.ChirpData['authorization']) {
	const likes = ref(chirp.likes_count)

	// In the context of infinite scrolling, it is not convenient to use
	// hybridly, because we would lose the scroll position and loaded
	// pagination. This is a good opportunity to simply use AJAX.
	async function toggleLike() {
		const [method, url] = authorization.like
			? ['post', route('chirp.like', { chirp })]
			: ['delete', route('chirp.unlike', { chirp })]

		await axios.request({ url, method }).then(({ status }) => {
			if (status === 204) {
				authorization.like = !authorization.like
				authorization.unlike = !authorization.unlike
			}
		})

		// Emits an event that says if the given chirp is liked or not.
		likeBus.emit({
			id: chirp.id,
			liked: !authorization.like,
		})
	}

	// All displayed chirps listen to this event to synchronize its
	// like authorization values, so likes are synchronized and
	// a request is avoided completely.
	likeBus.on(({ id, liked }) => {
		if (id === chirp.id) {
			authorization.like = !liked
			authorization.unlike = !authorization.like
			likes.value += liked ? +1 : -1
		}
	})

	return {
		likes,
		toggleLike,
	}
}

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
