<?php

const BASE_URL = '/';
const TEMP_PDF = '/temp-pdf/';

require_once($_SERVER['DOCUMENT_ROOT'] . '/credentials/cred_db_connect.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/helpers/is_file_pdf.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/helpers/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/helpers/subscribers.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/helpers/telegram.php');
