<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\WebsiteRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class WebsiteCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class WebsiteCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Website::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/website');
        CRUD::setEntityNameStrings('website', 'websites');

        CRUD::setShowView('vendor.backpack.base.website.show');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); 
        

        CRUD::removeColumns(['logo','colors','sub_caption', 'services', 'services', 'processes', 'about', 'qualifications', 'partners', 'testimonials'
        , 'social_media', 'achievements', 'interests', 'professions', 'ethnicities']);
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(WebsiteRequest::class);

        CRUD::addFields(
            [     
                [
                    'name' => 'logo',
                    'label'   => 'Upload Your Business Logo',
                    'type' => 'image',
                    'crop' => true
                ],
                [   // repeatable
                    'label'   => 'Preferred colors',
                    'name'  => 'colors',
                    'type'  => 'repeatable',
                    'fields' => [
                        [
                            'name'    => 'name',
                            'wrapper' => ['class' => 'form-group col-md-6']
                        ],      
                        // [
                        //     'name'    => 'color',
                        //     'type'    => 'color',
                        //     'wrapper' => ['class' => 'form-group col-md-6'],
                        //     'default' => '#000000',
                        // ]         
                    ],
                    'max_rows' => 2,
                    'new_item_label'  => 'Add Color'
                ],
                [
                    'name' => 'caption',
                ],
                [
                    'name' => 'sub_caption',
                ],
                [   // repeatable
                    'name'  => 'services',
                    'type'  => 'repeatable',
                    'fields' => [
                        [
                            'name'    => 'name',
                            'type'    => 'text',
                            'wrapper' => ['class' => 'form-group col-md-6'],
                            'attributes' => [
                                'required' => true,
                            ]
                        ],
                        [
                            'name'    => 'description',
                            'type'    => 'text',
                            'wrapper' => ['class' => 'form-group col-md-6'],
                            'attributes' => [
                                'required' => true,
                            ]
                        ]           
                    ],                
                    // optional
                    'new_item_label'  => 'Add Service', // customize the text of the button
                ],
                [   // repeatable
                    'name'  => 'processes',
                    'type'  => 'repeatable',
                    'fields' => [
                        [
                            'name'    => 'title',
                            'type'    => 'text',
                            'wrapper' => ['class' => 'form-group col-md-6'],
                            'attributes' => [
                                'required' => true,
                            ]
                        ],
                        [
                            'name'    => 'description',
                            'type'    => 'text',
                            'wrapper' => ['class' => 'form-group col-md-6'],
                            'attributes' => [
                                'required' => true,
                            ]
                        ]           
                    ],
                    'max_rows' => 2,
                    'new_item_label'  => 'Add Process'
                ],
                [
                    'name' => 'about',
                    'type'    => 'textarea'
                ],
                [   // Table
                    'name'            => 'achievements',
                    'type'            => 'table',
                    'entity_singular' => 'achievement', // used on the "Add X" button
                    'columns'         => [
                        'type'  => 'Type',
                        'title'  => 'Title'
                    ],
                    'max' => 5, // maximum rows allowed in the table
                    'min' => 0, // minimum rows allowed in the table
                ],
                [   // repeatable
                    'name'  => 'partners',
                    'type'  => 'repeatable',
                    'fields' => [
                        [
                            'name'    => 'name',
                            'type'    => 'text',
                            'wrapper' => ['class' => 'form-group col-md-6']
                        ],
                        [
                            'name'    => 'logo',
                            'type'    => 'image',
                            'wrapper' => ['class' => 'form-group col-md-6']
                        ]           
                    ],
                    'init_rows' => 5,
                    'new_item_label'  => 'Add Partner'
                ],
                [   // repeatable
                    'name'  => 'testimonials',
                    'type'  => 'repeatable',
                    'fields' => [
                        [
                            'name'    => 'customer',
                            'type'    => 'text',
                            'wrapper' => ['class' => 'form-group col-md-3']
                        ],
                        [
                            'name'    => 'company',
                            'type'    => 'text',
                            'wrapper' => ['class' => 'form-group col-md-3']
                        ],     
                        [
                            'name'    => 'testimonial',
                            'type'    => 'textarea',
                            'wrapper' => ['class' => 'form-group col-md-6']
                        ],    
                    ],
                    'init_rows' => 5,
                    'new_item_label'  => 'Add Testimonial'
                ],
                [
                    'name' => 'contact_name',
                ],
                [
                    'name' => 'contact_phone',
                ],
                [
                    'name' => 'contact_email',
                ],
                [   // Table
                    'name'            => 'social_media',
                    'type'            => 'table',
                    'entity_singular' => 'social media', // used on the "Add X" button
                    'columns'         => [
                        'type'  => 'Type',
                        'url'  => 'URL'
                    ],
                    'max' => 5, // maximum rows allowed in the table
                    'min' => 0, // minimum rows allowed in the table
                ],
                [
                    'name' => 'age_group',
                ],
                [   // repeatable
                    'label'   => 'Ethnicities',
                    'name'  => 'ethnicities',
                    'type'  => 'repeatable',
                    'fields' => [
                        [
                            'name'    => 'name',
                            'wrapper' => ['class' => 'form-group col-md-6']
                        ],      
                    ],
                    'max_rows' => 2,
                    'new_item_label'  => 'Add ethnicity'
                ],
                [
                    'name' => 'gender',
                ],
                [
                    'name' => 'professions',
                ],
                [
                    'name' => 'interests',
                ],
            ]
        );

        

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
