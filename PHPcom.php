<?php

class PHPcom #PHPcom object
{
  public $Baud;
  public $DataBits;
  public $StopBits;
  public $Port;

  public $PortHandle;

  public function __construct( $Port, $Baud, $DataBits, $StopBits ) #Class construcot
  {
    $this->Port = $Port;
    $this->Baud = $Baud;
    $this->DataBits = $DataBits;
    $this->StopBits = $StopBits;
  }

  public function Setup( ) #Setup port device file (takes really long time to execuse, use ONCE)
  {
    $Command = sprintf( "stty -F %s %d cs%d", $this->Port, $this->Baud, $this->DataBits );
    $Command .= " ignbrk -brkint -imaxbel -opost -onlcr -isig -icanon -iexten";
    $Command .= " -echo -echoe -echok -echoctl -echoke noflsh -ixon -crtscts";

    if ( $this->StopBits == 1 )
    {
      $Command .= " -cstopb";
    }
    else if ( $this->StopBits == 2 )
    {
      $Command .= " cstopb";
    }

    #echo $Command;
    exec( $Command ); #Execute command
  }

  public function Open( ) #Open serial port device file (takes medium amount of time [~30ms])
  {
    $this->PortHandle = fopen( $this->Port, "w+" );
    if ( !$this->PortHandle )
    {
      echo "Error with opening device!";
      die( );
    }
  }

  public function Close( ) #Close serial port device file (takes much time, do not use too often [200ms+])
  {
    fclose( $this->PortHandle );
  }

  public function Write( ) #Write data to serial port (doesn't take much time)
  {
    #Write( Data ) - write data and end with 0x00
    #Write( Data, EndChar ) - Write data and end with specified end character

    switch ( func_num_args( ) )
    {
      case 1: #No args, end with 0x00
        fwrite( $this->PortHandle, func_get_arg( 0 ) . 0x00 );
        break;

      case 2: #Enc char specified
        fwrite( $this->PortHandle, func_get_arg( 0 ) . func_get_arg( 1 ) );
        break;

      default:
        echo "Invalid argument count for PHPcom->Write( );";
        break;
    }
  }

  public function Read( ) #Read and return data from serial port (time depends on amount of data)
  {
    # Read( ) - read to 0x00
    # Read( Length ) - read specified number of characters or to 0x00
    # Read( Length, EndChar ) - read specified number of characters or to specified end character

    switch ( func_num_args( ) )
    {
      case 0: #No args, read to 0x00
        $Data = stream_get_line( $this->PortHandle, 0, 0x00 );
        break;

      case 1: #Length specified or read to 0x00
        $Data = stream_get_line( $this->PortHandle, func_get_arg( 0 ), 0x00 );
        break;

      case 2: #Length and end character specified
        $Data = stream_get_line( $this->PortHandle, func_get_arg( 0 ), func_get_arg( 1 ) );
        break;

      default:
        echo "Invalid argument count for PHPcom->Read( );";
        break;
    }
    return $Data;
  }
}

?>
