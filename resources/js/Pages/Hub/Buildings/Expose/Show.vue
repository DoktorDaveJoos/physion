<script setup>
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import BzCard from '../../Components/BzCard.vue';
import BuildingWrapper from '../Shared/BuildingWrapper.vue';
import MarkdownIt from 'markdown-it';
import MarkdownItStyle from 'markdown-it-style';
import { ElNotification } from 'element-plus';
import BzButton from '../../../../Components/BzButton.vue';
import relativeTime from 'dayjs/plugin/relativeTime';
import dayjs from 'dayjs';
import { ref, watch } from 'vue';
import DialogModal from '../../../../Components/DialogModal.vue';
import Badge from '../../../../Components/Badge.vue';
import { CheckIcon, ClipboardDocumentIcon } from '@heroicons/vue/24/outline';

dayjs.extend(relativeTime);
dayjs.locale('de');

const markdown = new MarkdownIt();
markdown.use(MarkdownItStyle, {
    h1: 'font-size:15px;font-weight:900;padding-bottom:1rem',
    h2: 'font-size:14px;font-weight:700;padding-bottom:1rem;padding-top:1rem',
    h3: 'font-size:13px;font-weight:600;padding-bottom:1rem;padding-top:1rem',
    p: 'font-size:13px;padding-bottom:0.2rem',
    li: 'font-size:13px;padding-bottom:0.1rem',
    ul: 'padding-left:0.5rem;padding-bottom:0.9rem',
});

const props = defineProps({
    building: Object,
    generating: {
        type: Boolean,
        default: false,
    },
});

const active = ref(
    props.building.data.predictions?.length === 0
        ? null
        : props.building.data.predictions[0]
);

const timer = ref(null);
const modal = ref(false);
const copyText = ref('kopieren');
const form = useForm({
    tags: [],
});

const generate = () => {
    form.post(route('buildings.expose.store', route().params?.building), {
        onSuccess: () => {
            modal.value = false;

            ElNotification({
                title: 'Exposè wird generiert',
                message: 'Dies kann etwas dauern. Bitte warten Sie.',
                type: 'success',
            });

            timer.value = setInterval(() => {
                router.reload({
                    onFinish: () => {
                        if (props.generating) {
                            return;
                        }
                        clearTimeout(timer.value);
                    },
                });
            }, 5000);
        },
        onError: () => {
            ElNotification({
                title: 'Exposè konnte nicht generiert werden',
                message: 'Bitte versuchen Sie es später erneut.',
                type: 'error',
            });
        },
    });
};

watch(
    () => props.building.data.predictions,
    (predictions) => {
        if (predictions?.length > 0 && !active.value?.id) {
            active.value = predictions[0];
        }
    }
);

const options = ['Charmant', 'Nüchtern', 'Kurz', 'Konservativ', 'Modern'];

const closeModal = () => {
    modal.value = false;
    form.reset();
};

const copyToClipboard = () => {
    navigator.clipboard.writeText(active.value.response);
    copyText.value = 'kopiert';
    setTimeout(() => {
        copyText.value = 'kopieren';
    }, 2000);
};

Echo.channel('team.' + usePage().props.auth.user.current_team_id).listen(
    '.expose.created',
    (e) => {
        ElNotification({
            title: 'Exposè wurde generiert',
            message: 'Das Exposè wurde erfolgreich generiert.',
            type: 'success',
        });
    }
);
</script>

<template>
    <Head>
        <title>Energieausweis</title>
    </Head>

    <building-wrapper :building="building">
        <bz-card class="mt-4">
            <template #title>Exposè Generator</template>
            <template #subtitle
                >Jetzt Exposè für das Gebäude generieren
            </template>
            <template #button>
                <bz-button :loading="generating" @click="modal = true"
                    >Exposè generieren
                </bz-button>
            </template>
            <template #content>
                <div
                    v-if="building.data.predictions?.length > 0"
                    class="grid grid-cols-4">
                    <div class="space-y-2 border-r px-4 py-4 border-gray-100">
                        <span
                            class="text-xs px-2 font-bold uppercase text-gray-500"
                            >Verlauf</span
                        >
                        <button
                            v-for="prediction in building.data.predictions"
                            :key="prediction.id"
                            :class="[
                                active.id === prediction.id
                                    ? 'border-primary-400 text-primary-600'
                                    : 'hover:border-gray-300',
                            ]"
                            class="px-4 py-2 border-2 border-gray-200 bg-gray-50 w-full rounded-md line-clamp-1 text-gray-600 text-sm font-semibold flex flex-col"
                            @click="active = prediction">
                            {{
                                prediction.response
                                    .slice(0, 30)
                                    .replace(/#/g, '')
                            }}...
                            <time
                                :datetime="prediction.created_at"
                                class="flex-none py-0.5 text-xs leading-5 text-gray-500"
                                >{{ dayjs(prediction.created_at).fromNow() }}
                            </time>
                        </button>
                    </div>

                    <div class="col-span-3">
                        <div class="flex justify-between">
                            <div
                                v-if="active.tags?.length > 0"
                                class="flex space-x-2 px-4 pt-4 items-start">
                                <badge
                                    v-for="tag in active.tags"
                                    :key="tag"
                                    :label="tag"
                                    size="sm" />
                            </div>
                            <div class="flex pr-4 pt-4">
                                <bz-button
                                    type="secondary"
                                    @click="copyToClipboard">
                                    {{ copyText }}
                                    <clipboard-document-icon
                                        v-if="copyText === 'kopieren'"
                                        class="w-5 h-5 -m-2 ml-2" />
                                    <check-icon
                                        v-else
                                        class="w-5 h-5 -m-2 ml-2" />
                                </bz-button>
                            </div>
                        </div>

                        <div
                            class="px-4 pb-6 pt-2 text-gray-700 rounded-br-lg"
                            v-html="markdown.render(active.response)"></div>
                    </div>
                </div>
                <el-empty
                    v-else
                    description="Es wurden noch keine Exposès generiert." />
            </template>
        </bz-card>
    </building-wrapper>
    <dialog-modal :show="modal" @close="closeModal">
        <template #title>Exposè generieren</template>
        <template #content>
            <p class="text-sm text-gray-500">
                Das Exposè wird im Hintergrund generiert. Dies kann einige
                Minuten dauern.
            </p>
            <p class="text-sm pt-6 text-gray-500">
                Sie können noch einige Schlagwörter hinzufügen, die im Exposè
                berücksichtigt werden sollen.
            </p>
            <div class="flex flex-col pt-2">
                <span class="text-sm text-gray-500">Schlagwörter</span>
                <el-select
                    v-model="form.tags"
                    class="w-full"
                    multiple
                    placeholder="Optional auswählen"
                    size="large">
                    <el-option
                        v-for="item in options"
                        :key="item"
                        :label="item"
                        :value="item" />
                </el-select>
            </div>
        </template>
        <template #footer>
            <div class="flex space-x-2">
                <bz-button type="primary" @click="generate"
                    >Exposè generieren
                </bz-button>
                <bz-button type="secondary" @click="closeModal"
                    >Schließen
                </bz-button>
            </div>
        </template>
    </dialog-modal>
</template>
