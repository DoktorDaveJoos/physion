import FormHeader from './FormHeader.vue';

export default {
    title: 'Example/FormHeader',
    component: FormHeader,
    // More on argTypes: https://storybook.js.org/docs/vue/api/argtypes
    argTypes: {
        title: String,
        subtitle: String,
    },
};

// More on component templates: https://storybook.js.org/docs/vue/writing-stories/introduction#using-args
const Template = (args) => ({
    // Components used in your story `template` are defined in the `components` object
    components: { FormHeader },
    // The story's `args` need to be mapped into the template through the `setup()` method
    setup() {
        return { args };
    },
    // And then the `args` are bound to your component with `v-bind="args"`
    template: '<FormHeader v-bind="args" />',
});

export const Example = Template.bind({});
// More on args: https://storybook.js.org/docs/vue/writing-stories/args
Example.args = {
    title: 'Example',
    subtitle: 'This is an example',
};

export const WithSwitcher = Template.bind({});

WithSwitcher.args = {
    title: 'HasSwitcher',
    subtitle: 'This is an example',
    switcher: false,
};
