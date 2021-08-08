using System;
using Microsoft.EntityFrameworkCore;
using MixYummy.Models;

namespace MixYummy.Data
{
    public class MixYummyContext : DbContext
    {
        public MixYummyContext(DbContextOptions<MixYummyContext> options)
            : base(options)
        {
        }

        public DbSet<TblProduct> TblProduct { get; set; }
    }
}
