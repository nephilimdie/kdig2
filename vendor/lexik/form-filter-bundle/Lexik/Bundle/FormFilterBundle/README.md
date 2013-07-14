Overview
========

This Symfony2 bundle aims to provide classes to build a form filter and then build a doctrine query from this form filter.

[![Build Status](https://travis-ci.org/lexik/LexikFormFilterBundle.png?branch=master)](https://travis-ci.org/lexik/LexikFormFilterBundle)

The idea is:

1. Create a form type extending from `Symfony\Component\Form\AbstractType` as usual.
2. Add form fields by using provided filter types (e.g. use `filter_text` instead of `text` type) (*).
3. Then call a service to build the query from the form instance and execute your query to get your result :).

(*): In fact you can use any type, but if you want to apply a filter by not using a `filter_xxx` type you will have to create a custom class to apply the filter for this type.

Documentation
=============

The `master` branch is now compatible with Symfony 2.1, if you are using Symfony 2.0.x use the `symfony2.0` branch.

For installation and how to use the bundle refer to [Resources/doc/index.md](https://github.com/lexik/LexikFormFilterBundle/blob/master/Resources/doc/index.md)
