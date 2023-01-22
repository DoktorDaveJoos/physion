import OrderBaseData from './OrderBaseData.vue';

// More on default export: https://storybook.js.org/docs/vue/writing-stories/introduction#default-export
export default {
    title: 'Example/OrderBaseData',
    component: OrderBaseData,
    // More on argTypes: https://storybook.js.org/docs/vue/api/argtypes
    argTypes: {
        isCreation: Boolean,
        context: String,
        order: Object,
    },
};

// More on component templates: https://storybook.js.org/docs/vue/writing-stories/introduction#using-args
const Template = (args) => ({
    // Components used in your story `template` are defined in the `components` object
    components: { OrderBaseData },
    // The story's `args` need to be mapped into the template through the `setup()` method
    setup() {
        return { args };
    },
    // And then the `args` are bound to your component with `v-bind="args"`
    template: '<Suspense><order-base-data v-bind="args" /></Suspense>',
});

export const Initial = Template.bind({});
// More on args: https://storybook.js.org/docs/vue/writing-stories/args

Initial.args = {
    isCreation: true,
    context: 'bedarf',
};

export const Normal = Template.bind({});

Normal.args = {
    context: 'bedarf',
    order: {
        id: 'wR0CSgsMk',
        customer_id: 2,
        type: 'bedarfsausweis',
        status: 'created',
        paid: false,
        product_id: 2,
        product_type: 'AppModelsBedarfsausweis',
        meta: {
            completed: ['general'],
        },
        created_at: '2023-01-22T15:10:33.000000Z',
        updated_at: '2023-01-22T15:10:33.000000Z',
        product: {
            id: 2,
            reason: 'Modernisierung/Änderung',
            street_address: 'Edensbach 8',
            zip: '88289',
            city: 'Waldburg',
            place_id: 'ChIJ30yC0hekm0cRljimUjXQ5Fg',
            type: 'Einfamilienhaus',
            additional_type: 'Freistehend',
            floor_area: null,
            housing_units: null,
            construction_year: null,
            construction_year_heating: null,
            ventilation: null,
            cellar: null,
            renewables: null,
            renewables_reason: null,
            cooling: null,
            cooling_count: null,
            cooling_service: null,
            side_a: null,
            side_b: null,
            maps: 'agreed',
            orientation: null,
            created_at: '2023-01-22T15:10:33.000000Z',
            updated_at: '2023-01-22T15:24:23.000000Z',
        },
        customer: {
            id: 2,
            name: 'Bertl',
            email: 'bertl@t-hotline.de',
            phone: null,
            address_line_1: null,
            address_line_2: null,
            postal_code: null,
            city: null,
            state: null,
            country: null,
            created_at: '2023-01-22T15:10:33.000000Z',
            updated_at: '2023-01-22T15:10:33.000000Z',
        },
    },
};
