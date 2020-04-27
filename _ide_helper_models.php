<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\addComprobante
 *
 * @property string $GuidDocument
 * @property string|null $RFCEmisor
 * @property string|null $NombreEmisor
 * @property string|null $RegimenEmisor
 * @property string|null $RegimenEmisorDesc
 * @property string|null $CURPEmisor
 * @property string|null $RFCReceptor
 * @property string|null $NombreReceptor
 * @property string|null $RegimenReceptor
 * @property float|null $TotImpRetenidos
 * @property float|null $TotImpTraslado
 * @property string|null $Version
 * @property string|null $Serie
 * @property string|null $Folio
 * @property \Illuminate\Support\Carbon|null $Fecha
 * @property int|null $FechaMes
 * @property int|null $FechaAnio
 * @property string|null $FormaPago
 * @property string|null $FormaPagoDesc
 * @property string|null $CondicionesPago
 * @property float|null $Subtotal
 * @property float|null $Descuento
 * @property float|null $TipoCambio
 * @property string|null $Moneda
 * @property string|null $MonedaDesc
 * @property float|null $Total
 * @property string|null $TipoComprobante
 * @property string|null $MetodoPago
 * @property string|null $MetodoPagoDesc
 * @property string|null $LugarExp
 * @property string|null $LugarExpDesc
 * @property string|null $UUID
 * @property \Illuminate\Support\Carbon|null $FechaTimbrado
 * @property int|null $FechaTimbradoMes
 * @property int|null $FechaTimbradoAnio
 * @property string|null $NumeroCertificado
 * @property string|null $Confirmacion
 * @property string|null $TipoDocumento
 * @property string|null $ResidenciaFiscal
 * @property string|null $ResidenciaFiscalDesc
 * @property string|null $NumRegIdTrib
 * @property string|null $UsoCFDI
 * @property string|null $UsoCFDI_Desc
 * @property string|null $TipoComprobanteDesc
 * @property string|null $NumCta
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereCURPEmisor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereCondicionesPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereConfirmacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereDescuento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereFechaAnio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereFechaMes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereFechaTimbrado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereFechaTimbradoAnio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereFechaTimbradoMes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereFolio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereFormaPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereFormaPagoDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereGuidDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereLugarExp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereLugarExpDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereMetodoPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereMetodoPagoDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereMoneda($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereMonedaDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereNombreEmisor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereNombreReceptor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereNumCta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereNumRegIdTrib($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereNumeroCertificado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereRFCEmisor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereRFCReceptor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereRegimenEmisor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereRegimenEmisorDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereRegimenReceptor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereResidenciaFiscal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereResidenciaFiscalDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereSerie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereTipoCambio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereTipoComprobante($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereTipoComprobanteDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereTipoDocumento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereTotImpRetenidos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereTotImpTraslado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereUUID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereUsoCFDI($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereUsoCFDIDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addComprobante whereVersion($value)
 */
	class addComprobante extends \Eloquent {}
}

namespace App{
/**
 * App\DocumentosDigitales
 *
 * @property string $GuidDocument
 * @property string|null $DocumentType
 * @property string|null $FileName
 * @property string|null $Content
 * @property string|null $SubDirectory
 * @property string|null $DocumentDate
 * @property string|null $CreationDate
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentosDigitales newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentosDigitales newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentosDigitales query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentosDigitales whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentosDigitales whereCreationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentosDigitales whereDocumentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentosDigitales whereDocumentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentosDigitales whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentosDigitales whereGuidDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentosDigitales whereSubDirectory($value)
 */
	class DocumentosDigitales extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $rfc
 * @property string $email
 * @property string $password
 * @property int $is_admin
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRfc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App{
/**
 * App\addDocumentContent
 *
 * @property string $GuidDocument
 * @property string|null $DocumentType
 * @property string|null $FileName
 * @property string|null $Content
 * @property string|null $SubDirectory
 * @property string|null $DocumentDate
 * @property string|null $CreationDate
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addDocumentContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addDocumentContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addDocumentContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addDocumentContent whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addDocumentContent whereCreationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addDocumentContent whereDocumentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addDocumentContent whereDocumentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addDocumentContent whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addDocumentContent whereGuidDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\addDocumentContent whereSubDirectory($value)
 */
	class addDocumentContent extends \Eloquent {}
}

