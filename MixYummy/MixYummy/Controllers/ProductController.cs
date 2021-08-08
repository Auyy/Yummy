using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Hosting;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.Rendering;
using Microsoft.EntityFrameworkCore;
using MixYummy.Data;
using MixYummy.Models;

namespace MixYummy.Controllers
{
    public class ProductController : Controller
    {
        private readonly MixYummyContext _context;
        private readonly IWebHostEnvironment _hostEnvironment;

        public ProductController(MixYummyContext context, IWebHostEnvironment hostEnvironment)
        {
            _context = context;
            _hostEnvironment = hostEnvironment;
        }

        // GET: Product
        public async Task<IActionResult> Index()
        {
            return View(await _context.TblProduct.ToListAsync());
        }

        // GET: Product/Details/5
        public async Task<IActionResult> Details(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var tblProduct = await _context.TblProduct
                .FirstOrDefaultAsync(m => m.Id == id);
            if (tblProduct == null)
            {
                return NotFound();
            }

            return View(tblProduct);
        }

        // GET: Product/Create
        public IActionResult Create()
        {
            return View();
        }

        // POST: Product/Create
        // To protect from overposting attacks, enable the specific properties you want to bind to.
        // For more details, see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> Create([Bind("Id,Name,ImageFile,taste,price")] TblProduct tblProduct)
        {
            if (ModelState.IsValid)
            {
                //Save image to wwwroot/image
                string wwwRootPath = _hostEnvironment.WebRootPath;
                string fileName = Path.GetFileNameWithoutExtension(tblProduct.ImageFile.FileName);
                string extension = Path.GetExtension(tblProduct.ImageFile.FileName);
                tblProduct.ImageName = fileName = fileName + DateTime.Now.ToString("yymmssfff") + extension;
                string path = Path.Combine(wwwRootPath + "/Image/", fileName);
                using (var fileStream = new FileStream(path, FileMode.Create))
                {
                    await tblProduct.ImageFile.CopyToAsync(fileStream);
                }

                if (_context.TblProduct.Any(ac => ac.Name.Equals(tblProduct.Name)))
                {
                    ModelState.AddModelError("Name", "Name already exists.");
                }
                else
                {
                    _context.Add(tblProduct);
                    await _context.SaveChangesAsync();
                    return RedirectToAction(nameof(Index));
                }
            }
            return View(tblProduct);
        }

        // GET: Product/Edit/5
        public async Task<IActionResult> Edit(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var tblProduct = await _context.TblProduct.FindAsync(id);
            if (tblProduct == null)
            {
                return NotFound();
            }
            return View(tblProduct);
        }

        // POST: Product/Edit/5
        // To protect from overposting attacks, enable the specific properties you want to bind to.
        // For more details, see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> Edit(int id, [Bind("Id,Name,ImageName,ImageFile,taste,price")] TblProduct tblProduct)
        {
            if (id != tblProduct.Id)
            {
                return NotFound();
            }

            if (ModelState.IsValid)
            {
                // ถ้า รูปมีการใส่ ค่า ก็ให้ save
                if (tblProduct.ImageFile != null)
                {
                    //Save image to wwwroot/image
                    string wwwRootPath = _hostEnvironment.WebRootPath;
                    string fileName = Path.GetFileNameWithoutExtension(tblProduct.ImageFile.FileName);
                    string extension = Path.GetExtension(tblProduct.ImageFile.FileName);
                    tblProduct.ImageName = fileName = fileName + DateTime.Now.ToString("yymmssfff") + extension;
                    string path = Path.Combine(wwwRootPath + "/Image/", fileName);
                    using (var fileStream = new FileStream(path, FileMode.Create))
                    {
                        await tblProduct.ImageFile.CopyToAsync(fileStream);
                    }
                }//เครื่องปิด if (movie.ImageFile != null)

                try
                {
                    _context.Update(tblProduct);
                    await _context.SaveChangesAsync();
                }
                catch (DbUpdateConcurrencyException)
                {
                    if (!TblProductExists(tblProduct.Id))
                    {
                        return NotFound();
                    }
                    else
                    {
                        throw;
                    }
                }
                return RedirectToAction(nameof(Index));
            }
            return View(tblProduct);
        }

        // GET: Product/Delete/5
        public async Task<IActionResult> Delete(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var tblProduct = await _context.TblProduct
                .FirstOrDefaultAsync(m => m.Id == id);
            if (tblProduct == null)
            {
                return NotFound();
            }

            return View(tblProduct);
        }

        // POST: Product/Delete/5
        [HttpPost, ActionName("Delete")]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> DeleteConfirmed(int id)
        {
            var Mimg = await _context.TblProduct.FindAsync(id);

            //delete image from wwwroot/image
            var imagePath = Path.Combine(_hostEnvironment.WebRootPath, "image", Mimg.ImageName);
            if (System.IO.File.Exists(imagePath))
                System.IO.File.Delete(imagePath);
            //delete the record
            var tblProduct = await _context.TblProduct.FindAsync(id);
            _context.TblProduct.Remove(tblProduct);
            await _context.SaveChangesAsync();
            return RedirectToAction(nameof(Index));
        }

        private bool TblProductExists(int id)
        {
            return _context.TblProduct.Any(e => e.Id == id);
        }
    }
}
