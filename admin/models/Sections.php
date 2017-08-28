<?php
	include_once('Connection.php');

	Class Sections extends Connection
	{
		private $SectionId;
    	private $Name;
		private $MetaTitle;
    	private $MetaDescription;
    	private $Keywords;

		//SET
		public function setSectionId($value)
		{
			$this->SectionId = $value;
		}

	    private function setName($value)
	    {
	    	$this->Name = $value;
	    }

		public function setMetaTitle($value)
		{
			$this->MetaTitle = $value;
		}

	    public function setMetaDescription($value)
		{
			$this->MetaDescription = $value;
		}

	    public function setKeywords($value)
		{
			$this->Keywords = $value;
		}

		//GET
		public function getSectionId()
		{
			return $this->SectionId;
		}

	    private function getName()
	    {
	      	return $this->Name;
	    }

		public function getMetaTitle()
		{
			return $this->MetaTitle;
		}

    	public function getMetaDescription()
		{
			return $this->MetaDescription;
		}

    	public function getKeywords()
		{
			return $this->Keywords;
		}

    	public function GetSectionContent()
		{
			try
			{
				$sql = "SELECT * FROM Sections WHERE SectionId = $this->SectionId";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				if($result->rowCount() > 0)
				{
					$fetchResult = $result->fetch(PDO::FETCH_ASSOC);
					return $fetchResult;
				}
				else return false;
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

  		public function ListSections()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											*
											FROM Sections
										");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function UpdateSection()
		{
			try
			{
				$sql = "UPDATE Sections SET MetaTitle = $this->MetaTitle, MetaDescription = $this->MetaDescription, Keywords = $this->Keywords
										WHERE SectionId = $this->SectionId";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				$query = $result->rowCount() ? true : false;
				if($query)
				{
					return "exito";
				}
				else
				{
					return "fallo";
				}
			}

			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}


	}

?>
