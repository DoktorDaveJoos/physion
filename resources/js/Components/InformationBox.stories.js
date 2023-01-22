import InformationBox from './InformationBox.vue';

// More on default export: https://storybook.js.org/docs/vue/writing-stories/introduction#default-export
export default {
    title: 'Example/InformationBox',
    component: InformationBox,
    // More on argTypes: https://storybook.js.org/docs/vue/api/argtypes
    argTypes: {
        to: String,
    },
};

// More on component templates: https://storybook.js.org/docs/vue/writing-stories/introduction#using-args
const Template = (args) => ({
    // Components used in your story `template` are defined in the `components` object
    components: { InformationBox },
    // The story's `args` need to be mapped into the template through the `setup()` method
    setup() {
        return { args };
    },
    // And then the `args` are bound to your component with `v-bind="args"`
    template:
        '<div id="test" class="p-12 border-2 border-rose-100"></div><InformationBox v-bind="args"><h1>Hallo Teleport</h1></InformationBox>',
});

export const Example = Template.bind({});
// More on args: https://storybook.js.org/docs/vue/writing-stories/args
Example.args = {
    to: '#test',
};
