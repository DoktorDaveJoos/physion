import { app } from '@storybook/vue3';
import '../resources/css/tailwind.scss';

import ElementPlus from 'element-plus';
import de from 'element-plus/dist/locale/de';
import 'dayjs/locale/de';
import '../resources/css/element-plus.scss';

app.use(ElementPlus, {
    locale: de,
});

export const parameters = {
    actions: { argTypesRegex: '^on[A-Z].*' },
    controls: {
        matchers: {
            color: /(background|color)$/i,
            date: /Date$/,
        },
    },
};
