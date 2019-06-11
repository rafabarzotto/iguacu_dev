/*
 * File: app/model/ControleEPI.js
 *
 * This file was generated by Sencha Architect version 3.2.0.
 * http://www.sencha.com/products/architect/
 *
 * This file requires use of the Ext JS 5.1.x library, under independent license.
 * License of Sencha Architect does not include license for Ext JS 5.1.x. For more
 * details see http://www.sencha.com/license or contact license@sencha.com.
 *
 * This file will be auto-generated each and everytime you save your project.
 *
 * Do NOT hand edit this file.
 */

Ext.define('TaskList.model.ControleEPI', {
    extend: 'Ext.data.Model',
    alias: 'model.controleepi',

    requires: [
        'Ext.data.field.String'
    ],

    fields: [
        {
            type: 'string',
            name: 'id'
        },
        {
            type: 'string',
            name: 'RE'
        },
        {
            type: 'string',
            name: 'Colaborador'
        },
        {
            type: 'string',
            name: 'Cargo'
        },
        {
            type: 'string',
            name: 'Setor'
        },
        {
            type: 'string',
            name: 'EPI'
        },
        {
            type: 'string',
            name: 'Data'
        },
        {
            type: 'string',
            name: 'Responsavel'
        },
        {
            type: 'string',
            name: 'stamp'
        },
        {
            type: 'string',
            name: 'verificado'
        }
    ]
});