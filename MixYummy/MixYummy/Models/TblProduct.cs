using System;
using System.ComponentModel;
using System.ComponentModel.DataAnnotations.Schema;
using Microsoft.AspNetCore.Http;

namespace MixYummy.Models
{
  
        public class TblProduct
        {
            public int Id { get; set; }

            public string Name { get; set; }

            public string ImageName { get; set; }

            [NotMapped]
            [DisplayName("Upload Image")]
            public IFormFile ImageFile { get; set; }

            public string taste { get; set; }

            public string price { get; set; }
        }
    }

