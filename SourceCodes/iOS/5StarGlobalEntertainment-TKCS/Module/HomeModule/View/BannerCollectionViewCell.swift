//
//  BannerCollectionViewCell.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 21/11/22.
//

import UIKit

class BannerCollectionViewCell: UICollectionViewCell {
    
    @IBOutlet weak var descriptionLbl: UILabel!
    @IBOutlet weak var bannerImage: UIImageView!
    func setDescription(description:String){
        let htmlString = description
        let data = htmlString.data(using: .utf8)!
        let attributedString = try? NSAttributedString(
            data: data,
            options: [.documentType: NSAttributedString.DocumentType.html],
            documentAttributes: nil)
        descriptionLbl.attributedText = attributedString
        descriptionLbl.textColor = .white
    }
}
