<?php

class Messages{
    public const ERROR_LOGIN = "Error de validación. Usuario o contraseña no corresponden, por favor verifique los datos e intente nuevamente.";
    public const UPDATE_OK = 'Actualización correcta';
    public const GENERIC_ERROR = 'La transacción no se pudo realizar. Detalle del error: ';
    public const NO_PERMISSION_ACTION = 'Usted no tiene permiso para realizar esta acción.';
    public const UPLOAD_GENERIC_ERROR = 'Hubo un error moviendo el archivo al directorio, por favor asegurese de que el directorio puede ser escrito.';
    public const UPLOAD_GENERIC_ERROR_2 = 'Ocurrió un error al subir la imagen. Error:';
    public const UPLOAD_EXT_ERROR = 'Error al subir el archivo, extensiones permitidas: ';
    public const UPLOAD_DIM_ERROR = 'La imagen seleccionada debe ser de 800 x 800 pixeles.';
    public const RELATED_REG_DELETE_ERROR = 'No es posible eliminar este registro, ya que tiene otros registros vinculados. Elimine primero todos los registros asociados.';
    public const DELETE_SUCCESS = 'Registro eliminado correctamente.';
    public const DUPLICATED_CREATE_ERROR = 'Este registro no pudo guardarse porque ya se encuentra en el sistema.';
    public const CREATE_SUCCESS = 'Registro guardado correctamente.';
    public const DUPLICATED_UPDATE_ERROR = 'Este registro no pudo actualizarse porque ya se encuentra otro registro igual en el sistema.';
    public const UPDATE_SUCCESS = 'Registro actualizado correctamente.';
    public const ICON_UPLOAD_ERROR = 'La imagen seleccionada debe ser cuadrada y mínimo 400 px.';

}

?>